<?php
header("Content-Type: application/json; charset=utf-8");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
require_once __DIR__ . "/mastery_helper.php";

function respond($status, $data)
{
    http_response_code($status);
    echo json_encode($data);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    respond(405, [
        "success" => false,
        "message" => "Use POST to submit an assessment."
    ]);
}

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    respond(400, [
        "success" => false,
        "message" => "Invalid JSON."
    ]);
}

$studentId = $data["student_id"] ?? null;
$encounterId = $data["encounter_id"] ?? null;
$chapter = $data["chapter_id"] ?? null;
$quizType = $data["quiz_type"] ?? null;
$score = $data["correct_answers"] ?? null;
$total = $data["total_questions"] ?? null;

if (!is_string($studentId) ||
    trim($studentId) === "" ||
    strlen(trim($studentId)) > 255 ||
    !is_string($encounterId) ||
    !is_int($chapter) ||
    !is_int($score) ||
    !is_int($total) ||
    $total <= 0 ||
    $score < 0 ||
    $score > $total) {
    respond(400, [
        "success" => false,
        "message" => "Invalid assessment fields."
    ]);
}

$studentId = trim($studentId);

// Only these known assessment IDs can select a database column.
$assessments = [
    "C1_Pretest" => ["Chapter1_Pre", 1, "PreTest"],
    "C1_Posttest" => ["Chapter1_Post", 1, "PostTest"],
    "C1_RE_01" => ["Chapter1_RE1", 1, "RandomEncounter"],
    "C1_RE_02" => ["Chapter1_RE2", 1, "RandomEncounter"],
    "C1_RE_03" => ["Chapter1_RE3", 1, "RandomEncounter"],

    "C2_Pretest" => ["Chapter2_Pre", 2, "PreTest"],
    "C2_Posttest" => ["Chapter2_Post", 2, "PostTest"],
    "C2_RE_PotsVases" => ["Chapter2_RE1", 2, "RandomEncounter"],
    "C2_RE_Podium" => ["Chapter2_RE2", 2, "RandomEncounter"],
    "C2_RE_Crown" => ["Chapter2_RE3", 2, "RandomEncounter"],
    "C2_RE_Tools" => ["Chapter2_RE4", 2, "RandomEncounter"]
];

if (!isset($assessments[$encounterId])) {
    respond(400, [
        "success" => false,
        "message" => "Unknown assessment ID."
    ]);
}

$config = $assessments[$encounterId];

if ($chapter !== $config[1] || $quizType !== $config[2]) {
    respond(400, [
        "success" => false,
        "message" => "Assessment chapter or type does not match its ID."
    ]);
}

$column = $config[0];

try {
    $conn = new mysqli("localhost", "root", "", "divinedb");
    $conn->set_charset("utf8mb4");
    $conn->begin_transaction();

    // Confirm that this student exists.
    $check = $conn->prepare(
        "SELECT ID FROM student WHERE ID = ? LIMIT 1 FOR UPDATE"
    );
    $check->bind_param("s", $studentId);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        $conn->rollback();
        respond(404, [
            "success" => false,
            "message" => "Student ID not found."
        ]);
    }

    $check->close();

    // Create the student's row or update only this assessment.
    // Repeated uploads cannot lower the saved score.
    $stmt = $conn->prepare(
        "INSERT INTO records (`ID`, `$column`)
         VALUES (?, ?)
         ON DUPLICATE KEY UPDATE
         `$column` = GREATEST(COALESCE(`$column`, 0), ?)"
    );

    $stmt->bind_param("sii", $studentId, $score, $score);
    $stmt->execute();

    $stmt->close();

    saveAssessmentMasteryScore(
        $conn,
        $studentId,
        $chapter,
        $encounterId,
        $quizType,
        $score,
        $total
    );

    $mastery = recalculateChapterMastery(
        $conn,
        $studentId,
        $chapter
    );

    $conn->commit();

        respond(200, [
        "success" => true,
        "message" => "Assessment saved. Highest score retained.",
        "column" => $column,
        "submitted_score" => $score,
        "mastery_percentage" => $mastery,
        "mastery_complete" => $mastery !== null
    ]);
}
catch (Throwable $error) {
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->rollback();
    }
    error_log($error->getMessage());

    respond(500, [
        "success" => false,
        "message" => "Unable to save assessment."
    ]);
}
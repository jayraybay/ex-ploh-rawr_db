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
        "message" => "Use POST to submit a minigame result."
    ]);
}

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    respond(400, [
        "success" => false,
        "message" => "Invalid JSON."
    ]);
}

$attempt = $data["attempt_id"] ?? null;
$student = $data["student_id"] ?? null;
$chapter = $data["chapter_id"] ?? null;
$minigame = $data["minigame_id"] ?? null;
$score = $data["score"] ?? null;
$maximum = $data["max_score"] ?? null;
$outcome = $data["outcome"] ?? null;
$completed = $data["completed_at_utc"] ?? null;

if (!is_string($attempt) ||
    !preg_match('/^[a-f0-9]{32}$/i', $attempt) ||
    !is_string($student) ||
    trim($student) === "" ||
    strlen(trim($student)) > 255 ||
    !is_int($chapter) ||
    !is_string($minigame) ||
    !is_int($score) ||
    !is_int($maximum) ||
    $maximum < 0 ||
    $score > $maximum ||
    !is_string($outcome) ||
    !in_array($outcome, ["Win", "Fail"], true) ||
    !is_string($completed) ||
    strlen($completed) > 40 ||
    strtotime($completed) === false) {
    respond(400, [
        "success" => false,
        "message" => "Invalid minigame result fields."
    ]);
}

$expectedChapters = [
    "TowerDefense" => 1,
    "Sledgehammer" => 2,
    "RepairSyntax" => 2
];

if (!isset($expectedChapters[$minigame]) ||
    $chapter !== $expectedChapters[$minigame]) {
    respond(400, [
        "success" => false,
        "message" => "Unknown minigame or incorrect chapter."
    ]);
}

if ($minigame !== "Sledgehammer" && $score < 0) {
    respond(400, [
        "success" => false,
        "message" => "This minigame cannot have a negative score."
    ]);
}

$student = trim($student);

try {
    $conn = new mysqli("localhost", "root", "", "divinedb");
    $conn->set_charset("utf8mb4");
    $conn->begin_transaction();

    $check = $conn->prepare(
        "SELECT ID FROM student WHERE ID = ? LIMIT 1 FOR UPDATE"
    );

    $check->bind_param("s", $student);
    $check->execute();
    $check->store_result();
    $conn->rollback();

    if ($check->num_rows === 0) {
        respond(404, [
            "success" => false,
            "message" => "Student ID not found."
        ]);
    }

    $check->close();

    // A repeated attempt ID leaves the original record unchanged.
    $stmt = $conn->prepare(
        "INSERT INTO minigame_results
            (attempt_id, student_id, chapter_id, minigame_id,
             score, max_score, outcome, completed_at_utc)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE attempt_id = attempt_id"
    );

    $stmt->bind_param(
        "ssisiiss",
        $attempt,
        $student,
        $chapter,
        $minigame,
        $score,
        $maximum,
        $outcome,
        $completed
    );

    $stmt->execute();

    $stmt->close();

    $mastery = recalculateChapterMastery(
        $conn,
        $student,
        $chapter
    );

$conn->commit();

    respond(200, [
        "success" => true,
        "message" => "Minigame result saved or already recorded.",
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
        "message" => "Unable to save minigame result."
    ]);
}
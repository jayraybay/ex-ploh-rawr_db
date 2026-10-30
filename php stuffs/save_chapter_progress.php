<?php
header("Content-Type: application/json; charset=utf-8");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function respond($status, $data)
{
    http_response_code($status);
    echo json_encode($data);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    respond(405, [
        "success" => false,
        "message" => "Use POST to submit chapter progression."
    ]);
}

$data = json_decode(file_get_contents("php://input"), true);

if (!is_array($data)) {
    respond(400, [
        "success" => false,
        "message" => "Invalid JSON."
    ]);
}

$student = $data["student_id"] ?? null;
$chapter = $data["chapter"] ?? null;
$progress = $data["chapter_progression"] ?? null;

if (!is_string($student) ||
    trim($student) === "" ||
    strlen(trim($student)) > 100 ||
    !is_int($chapter) ||
    !in_array($chapter, [1, 2], true) ||
    (!is_int($progress) && !is_float($progress)) ||
    !is_finite((float)$progress) ||
    $progress < 0 ||
    $progress > 100) {
    respond(400, [
        "success" => false,
        "message" => "Invalid progression fields."
    ]);
}

$student = trim($student);
$chapterText = (string)$chapter;
$progress = round((float)$progress, 2);

try {
    $conn = new mysqli("localhost", "root", "", "divinedb");
    $conn->set_charset("utf8mb4");

    $check = $conn->prepare(
        "SELECT ID FROM student WHERE ID = ? LIMIT 1"
    );
    $check->bind_param("s", $student);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        respond(404, [
            "success" => false,
            "message" => "Student ID not found."
        ]);
    }

    $check->close();

    $stmt = $conn->prepare(
        "INSERT INTO student_chapter_progress
            (student_id, chapter, chapter_progression)
         VALUES (?, ?, ?)
         ON DUPLICATE KEY UPDATE
            chapter_progression =
                GREATEST(chapter_progression, ?)"
    );

    $stmt->bind_param(
        "ssdd",
        $student,
        $chapterText,
        $progress,
        $progress
    );
    $stmt->execute();

    $read = $conn->prepare(
        "SELECT chapter_progression
         FROM student_chapter_progress
         WHERE student_id = ? AND chapter = ?"
    );
    $read->bind_param("ss", $student, $chapterText);
    $read->execute();
    $read->bind_result($savedProgress);
    $read->fetch();

    respond(200, [
        "success" => true,
        "message" => "Chapter progression saved.",
        "chapter" => $chapter,
        "chapter_progression" => (float)$savedProgress
    ]);
}
catch (Throwable $error) {
    error_log($error->getMessage());

    respond(500, [
        "success" => false,
        "message" => "Unable to save chapter progression."
    ]);
}
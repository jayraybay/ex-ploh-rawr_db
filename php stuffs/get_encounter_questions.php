<?php
header("Content-Type: application/json; charset=utf-8");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function respond($status, $data)
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

$first = filter_input(INPUT_GET, "first", FILTER_VALIDATE_INT);
$last = filter_input(INPUT_GET, "last", FILTER_VALIDATE_INT);

if ($first === false || $first === null ||
    $last === false || $last === null ||
    $first < 1 || $last < $first)
{
    respond(400, [
        "success" => false,
        "message" => "Invalid question ID range.",
        "questions" => []
    ]);
}

try
{
    // Change these to your local XAMPP database settings.
    $conn = new mysqli("localhost", "root", "", "divinedb");
    $conn->set_charset("utf8mb4");

    $stmt = $conn->prepare(
        "SELECT Indicate, Exam, Choice1, Choice2, Choice3, Choice4, Answer
         FROM teacher_content
         WHERE Indicate BETWEEN ? AND ?
         ORDER BY Indicate ASC"
    );

    $stmt->bind_param("ii", $first, $last);
    $stmt->execute();
    
    $stmt->bind_result(
    $id,
    $question,
    $choice1,
    $choice2,
    $choice3,
    $choice4,
    $answer
);

    $questions = [];

    while ($stmt->fetch())
    {
        $questions[] = [
            "id" => $id,
            "question" => trim((string)$question),
            "choices" => [
                trim((string)$choice1),
                trim((string)$choice2),
                trim((string)$choice3),
                trim((string)$choice4)
            ],
            "answer" => trim((string)$answer)
        ];
    }

    respond(200, [
        "success" => true,
        "message" => "",
        "questions" => $questions
    ]);
}
catch (Throwable $error)
{
    error_log($error->getMessage());

    respond(500, [
        "success" => false,
        "message" => "Unable to load questions.",
        "questions" => []
    ]);
}
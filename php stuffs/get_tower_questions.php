<?php
header("Content-Type: application/json; charset=utf-8");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function respond($status, $data)
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function answerLines($text)
{
    $lines = preg_split('/\R/u', (string)$text);
    $answers = [];

    foreach ($lines as $line) {
        $answer = trim($line);

        if ($answer !== "") {
            $answers[] = $answer;
        }
    }

    return $answers;
}

$chapter = filter_input(INPUT_GET, "chapter", FILTER_VALIDATE_INT);

if ($chapter !== 1 && $chapter !== 2) {
    respond(400, [
        "success" => false,
        "message" => "Invalid chapter.",
        "questions" => []
    ]);
}

try {
    $conn = new mysqli("localhost", "root", "", "divinedb");
    $conn->set_charset("utf8mb4");

    $stmt = $conn->prepare(
        "SELECT id, question, correct_answers, wrong_answers
         FROM tower_defense_content
         WHERE chapter_id = ? AND enabled = 1
         ORDER BY id"
    );

    $stmt->bind_param("i", $chapter);
    $stmt->execute();
    $stmt->bind_result($id, $question, $correct, $wrong);

    $questions = [];

    while ($stmt->fetch()) {
        $correctAnswers = answerLines($correct);
        $wrongAnswers = answerLines($wrong);

        if (trim($question) === "" ||
            count($correctAnswers) === 0 ||
            count($wrongAnswers) === 0) {
            respond(500, [
                "success" => false,
                "message" => "Incomplete content at ID " . $id,
                "questions" => []
            ]);
        }

        $questions[] = [
            "id" => $id,
            "question" => trim($question),
            "correctAnswers" => $correctAnswers,
            "wrongAnswers" => $wrongAnswers
        ];
    }

    respond(200, [
        "success" => true,
        "message" => "",
        "questions" => $questions
    ]);
}
catch (Throwable $error) {
    error_log($error->getMessage());

    respond(500, [
        "success" => false,
        "message" => "Unable to load Tower Defense content.",
        "questions" => []
    ]);
}
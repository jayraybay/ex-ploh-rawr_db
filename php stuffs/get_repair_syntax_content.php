<?php
header("Content-Type: application/json; charset=utf-8");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function respond($status, $data)
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

$chapter = filter_input(INPUT_GET, "chapter", FILTER_VALIDATE_INT);

if ($chapter !== 1 && $chapter !== 2) {
    respond(400, [
        "success" => false,
        "message" => "Invalid chapter.",
        "challenges" => []
    ]);
}

try {
    $conn = new mysqli("localhost", "root", "", "divinedb");
    $conn->set_charset("utf8mb4");

    $stmt = $conn->prepare(
        "SELECT id, challenge_name, waves_json
         FROM repair_syntax_content
         WHERE chapter_id = ? AND enabled = 1
         ORDER BY id"
    );

    $stmt->bind_param("i", $chapter);
    $stmt->execute();
    $stmt->bind_result($id, $name, $wavesJson);

    $challenges = [];

    while ($stmt->fetch()) {
        $waves = json_decode($wavesJson, true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($waves) || count($waves) !== 1) {
            throw new Exception(
                "Challenge " . $id . " must contain exactly one wave."
            );
        }

        $challenges[] = [
            "id" => $id,
            "Name" => $name,
            "waves" => $waves
        ];
    }

    respond(200, [
        "success" => true,
        "message" => "",
        "challenges" => $challenges
    ]);
}
catch (Throwable $error) {
    error_log($error->getMessage());

    respond(500, [
        "success" => false,
        "message" => "Unable to load Repair Syntax content.",
        "challenges" => []
    ]);
}
<?php

function saveAssessmentMasteryScore(
    mysqli $conn,
    string $student,
    int $chapter,
    string $encounter,
    string $type,
    int $score,
    int $total
): void {
    // Preserve the maximum belonging to the highest raw score.
    // On a tied score, retain the existing result.
    $stmt = $conn->prepare(
        "INSERT INTO assessment_mastery_scores
            (student_id, chapter, encounter_id, quiz_type,
             correct_answers, total_questions)
         VALUES (?, ?, ?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE
            total_questions = IF(
                VALUES(correct_answers) > correct_answers,
                VALUES(total_questions),
                total_questions
            ),
            correct_answers = GREATEST(
                correct_answers,
                VALUES(correct_answers)
            )"
    );

    $stmt->bind_param(
        "sissii",
        $student,
        $chapter,
        $encounter,
        $type,
        $score,
        $total
    );

    $stmt->execute();
    $stmt->close();
}

function recalculateChapterMastery(
    mysqli $conn,
    string $student,
    int $chapter
): ?float {
    $requirements = [
        1 => [
            "pre" => "C1_Pretest",
            "post" => "C1_Posttest",
            "encounters" => [
                "C1_RE_01",
                "C1_RE_02",
                "C1_RE_03"
            ],
            "minigames" => [
                "TowerDefense"
            ]
        ],
        2 => [
            "pre" => "C2_Pretest",
            "post" => "C2_Posttest",
            "encounters" => [
                "C2_RE_PotsVases",
                "C2_RE_Podium",
                "C2_RE_Crown",
                "C2_RE_Tools"
            ],
            "minigames" => [
                "Sledgehammer",
                "RepairSyntax"
            ]
        ]
    ];

    if (!isset($requirements[$chapter])) {
        throw new InvalidArgumentException("Unknown chapter.");
    }

    $required = $requirements[$chapter];

    // Read assessment scores and their matching maximum scores.
    $stmt = $conn->prepare(
        "SELECT encounter_id, correct_answers, total_questions
         FROM assessment_mastery_scores
         WHERE student_id = ? AND chapter = ?"
    );

    $stmt->bind_param("si", $student, $chapter);
    $stmt->execute();

    $result = $stmt->get_result();
    $assessments = [];

    while ($row = $result->fetch_assoc()) {
        $assessments[$row["encounter_id"]] = $row;
    }

    $stmt->close();

    // Read every minigame attempt for this chapter.
    $stmt = $conn->prepare(
        "SELECT minigame_id, score, max_score
         FROM minigame_results
         WHERE student_id = ? AND chapter_id = ?"
    );

    $stmt->bind_param("si", $student, $chapter);
    $stmt->execute();

    $result = $stmt->get_result();
    $bestMinigames = [];

    while ($row = $result->fetch_assoc()) {
        $game = $row["minigame_id"];

        if (!in_array($game, $required["minigames"], true)) {
            continue;
        }

        $maximum = (int) $row["max_score"];
        $percentage = 0.0;

        if ($maximum > 0) {
            $percentage =
                ((int) $row["score"] / $maximum) * 100.0;
        }

        // Sledgehammer penalties can produce negative scores.
        // Mastery contributions remain within 0–100%.
        $percentage = max(0.0, min(100.0, $percentage));

        if (!array_key_exists($game, $bestMinigames)) {
            $bestMinigames[$game] = $percentage;
        } elseif ($percentage > $bestMinigames[$game]) {
            $bestMinigames[$game] = $percentage;
        }
    }

    $stmt->close();

    $complete = true;

    $requiredAssessmentIds = array_merge(
        [$required["pre"], $required["post"]],
        $required["encounters"]
    );

    foreach ($requiredAssessmentIds as $id) {
        if (!isset($assessments[$id])) {
            $complete = false;
            continue;
        }

        if ((int) $assessments[$id]["total_questions"] <= 0) {
            $complete = false;
        }
    }

    foreach ($required["minigames"] as $game) {
        if (!array_key_exists($game, $bestMinigames)) {
            $complete = false;
        }
    }

    // NULL means required results are still missing.
    $mastery = null;

    if ($complete) {
        $pre = $assessments[$required["pre"]];
        $post = $assessments[$required["post"]];

        $prePercentage =
            ((int) $pre["correct_answers"]
            / (int) $pre["total_questions"]) * 100.0;

        $postPercentage =
            ((int) $post["correct_answers"]
            / (int) $post["total_questions"]) * 100.0;

        $encounterCorrect = 0;
        $encounterTotal = 0;

        foreach ($required["encounters"] as $id) {
            $encounterCorrect +=
                (int) $assessments[$id]["correct_answers"];

            $encounterTotal +=
                (int) $assessments[$id]["total_questions"];
        }

        $encounterPercentage =
            ($encounterCorrect / $encounterTotal) * 100.0;

        $minigameSum = 0.0;

        foreach ($required["minigames"] as $game) {
            $minigameSum += $bestMinigames[$game];
        }

        $minigamePercentage =
            $minigameSum / count($required["minigames"]);

        $mastery = round(
            ($prePercentage * 0.10)
            + ($postPercentage * 0.50)
            + ($encounterPercentage * 0.25)
            + ($minigamePercentage * 0.15),
            2
        );
    }

    $stmt = $conn->prepare(
        "INSERT INTO student_chapter_mastery
            (student_id, chapter, mastery_percentage)
         VALUES (?, ?, ?)
         ON DUPLICATE KEY UPDATE
            mastery_percentage = VALUES(mastery_percentage)"
    );

    $stmt->bind_param("sid", $student, $chapter, $mastery);
    $stmt->execute();
    $stmt->close();

    return $mastery;
}
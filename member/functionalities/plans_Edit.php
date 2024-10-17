<?php

require_once '../../include/config.php';
require_once '../../include/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $day = $_POST["day"];
    $date = $_POST["date"];
    $workout_day = $_POST["workout_day"];
    $exercise = isset($_POST["exercise"]) ? implode(',', $_POST["exercise"]) : null;
    $diet_plan = $_POST["diet_plan"];
    $member_id = intval($_POST["member_id"]);
    $plans_id = intval($_POST["plans_id"]);

    try {
        $query = "UPDATE plans SET members_id = :member_id, day = :day, date = :date, workout_day = :workout_day,
            exercise = :exercise, diet_plan = :diet_plan WHERE plans_id = :plans_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":member_id", $member_id);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":day", $day);
        $stmt->bindParam(":workout_day", $workout_day);
        $stmt->bindParam(":exercise", $exercise);
        $stmt->bindParam(":diet_plan", $diet_plan);
        $stmt->bindParam(":plans_id", $plans_id);
        $stmt->execute();

        header("Location: ../plans/edit_plans.php?plans=updated&plans_id=" . $plans_id);
        $pdo = null;
        $stmt = null;

        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../plans/edit_plans.php");
    die();
}

<?php
require_once '../../include/config.php';
require_once '../../include/session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $day = $_POST["day"];
    $date = $_POST["date"];
    $workout_day = $_POST["workout_day"];

    if (empty($_POST["exercise"])) {
        die("Please select at least one exercise.");
    } else {
        $exercise = implode(',', $_POST["exercise"]); // Convert selected exercises to a string
    }

    $diet_plan = $_POST["diet_plan"];
    $member_id = intval($_POST["member_id"]);

    try {
        $query = "INSERT INTO plans (members_id, date, day, workout_day, exercise, diet_plan) VALUES (:member_id, :date, :day, :workout_day, :exercise, :diet_plan);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":member_id", $member_id);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":day", $day);
        $stmt->bindParam(":workout_day", $workout_day);
        $stmt->bindParam(":exercise", $exercise);
        $stmt->bindParam(":diet_plan", $diet_plan);
        $stmt->execute();

        header("Location: ../plans/index_plans.php?input=success");
        $pdo = null;
        $stmt = null;

        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../plans/index_plans.php");
    die();
}
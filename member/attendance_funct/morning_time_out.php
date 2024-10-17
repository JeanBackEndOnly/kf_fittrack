<?php

require_once '../../include/config.php';
require_once '../../include/session.php';

echo $member_id = isset($_GET["members_id"]) ? $_GET["members_id"] : null;

if($member_id){
    $query = "SELECT * FROM attendance WHERE members_id = :member_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":member_id", $member_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $time_out){
        $Mtime_Out = isset($time_out["Mtime_out"]) ? $time_out["Mtime_out"] : null;
        $attendance_At = isset($time_out["attendance_at"]) ? $time_out["attendance_at"] : null;
    }
} else {
    die("No member ID found");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $Mtime_out = $_POST["Mtime_out"];

    try {

        if(empty($Mtime_out)) {
            $errors["empty"] = "Time out cannot be empty!";
        }
            $errors = [];

            if($Mtime_out > "11:59:59" && $Mtime_out < "01:00:00"){
                $errors["noon"] = "IT'S CURRENTLY " . $Mtime_out . " IN THE NOON_TIME YOU CAN'T TIME OUT AT MORNING!";
            }
            else if($Mtime_out > "12:59:59" && $Mtime_out < "18:00:00"){
                $errors["afterNoon"] = "IT'S CURRENTLY " . $Mtime_out . " IN THE AFFTERNOON YOU CAN'T TIME OUT AT MORNING!";
            }
            else if($Mtime_out > "17:59:59" && $Mtime_out < "22:00:00"){
                $errors["evening"] = "IT'S CURRENTLY " . $Mtime_out . " IN THE EVENING YOU CAN'T TIME OUT AT MORNING!";
            }
            else if(($Mtime_out > "22:00:59" && $Mtime_out <= "23:59:59") || ($Mtime_out >= "00:00:00" && $Mtime_out < "07:00:00")){
                $errors["late-hour"] = "NO ATTENDANCE IN THIS HOUR!";
            }
            else if ($Mtime_Out !== NULL && isset($attendance_At) && $attendance_At == date('Y-m-d')) {
                $errors["empty"] = "You've already made an attendance in this time!";
            }   

            if($errors) {
                $_SESSION["time_errors"] = $errors;
                header("Location: ../attendance/attendance.php");
                die();
            } else {
                $query = "INSERT INTO attendance (Mtime_out, members_id) VALUES (:current_time, :members_id)";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":current_time", $current_time);
                $stmt->bindParam(":members_id", $member_id);
                $stmt->execute();
    
                header("Location: ../attendance/attendance.php?success=attendance");
                $stmt = null;
                $pdo = null;
                die();
            }
        } catch(PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    } else {
        header("Location: ../attendance/attendance.php");
        die();
    }
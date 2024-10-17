<?php

require_once '../../include/config.php';
require_once '../../include/session.php';

$member_id = isset($_GET["members_id"]) ? $_GET["members_id"] : null;

if($member_id){
    $query = "SELECT * FROM attendance WHERE members_id = :member_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":member_id", $member_id);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $time_out){
        $time_In = isset($time_out["Mtime_out"]) ? $time_out["Mtime_out"] : null;
        $attendance_At = isset($time_out["attendance_at"]) ? $time_out["attendance_at"] : null;
    }
} else {
    die("No member ID found");
}
$current_time;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $Mtime_in = $_POST["Mtime_in"];
    $members_id = $_POST["members_id"];
        try{

            $errors = [];

            if($current_time < "01:00:00" && $current_time > "11:59:59"){
                $errors["noon"] = "IT'S CURRENTLY " . $current_time . " IN THE NOON_TIME YOU CAN'T TIME OUT AT MORNING!";
            }
            else if($current_time > "12:59:59" && $current_time < "18:00:00"){
                $errors["afterNoon"] = "IT'S CURRENTLY " . $current_time . " IN THE AFFTERNOON YOU CAN'T TIME OUT AT MORNING!";
            }
            else if($current_time > "17:59:59" && $current_time < "22:00:00"){
                $errors["evening"] = "IT'S CURRENTLY " . $current_time . " IN THE EVENING YOU CAN'T TIME OUT AT MORNING!";
            }
            else if(($current_time > "22:00:59" && $current_time <= "23:59:59") || ($current_time >= "00:00:00" && $current_time < "07:00:00")){
                $errors["late-hour"] = "NO ATTENDANCE IN THIS HOUR!";
            }
            else if (!empty($time_In) && isset($attendance_At) && $attendance_At == date('Y-m-d')) {
                $errors["empty"] = "You've already made an attendance in this time!";
            }  

            if($errors){
                $_SESSION["time_errors"] = $errors;
                header("Location: ../attendance/attendance.php");
                die();
            }else{
            
            $query = "INSERT INTO attendance (Mtime_in, members_id) VALUES (:current_time, :member_id)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":current_time", $current_time);
            $stmt->bindParam(":member_id", $member_id);
            $stmt->execute();

            header("Location: ../attendance/attendance.php?success=attendance");
            $stmt = null;
            $pdo = null;
            die();
            }
        
        }catch(PDOException $e){
            die("query failed: " . $e->getMessage());
        }
        
    }else{
    header("Location: ../attendance/attendance.php");
    die();
}
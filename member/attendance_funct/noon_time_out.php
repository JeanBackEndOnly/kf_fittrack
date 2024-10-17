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
        echo $time_Out = isset($time_out["Ntime_out"]) ? $time_out["Ntime_out"] : null;
        echo $attendance_At = isset($time_out["attendance_at"]) ? $time_out["attendance_at"] : null;
    }
} else {
    die("No member ID found");
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $Ntime_out = $_POST["Ntime_out"];
        try{

            $errors = [];

            if($Ntime_out > "06:59:59" && $Ntime_out < "12:00:00"){
                $errors["afterNoon"] = "IT'S CURRENTLY " . $Ntime_out . " IN THE MORNING YOU CAN'T TIME OUT AT NOON_TIME!";
            }
            else if($Ntime_out > "12:59:59" && $Ntime_out < "18:00:00"){
                $errors["afterNoon"] = "IT'S CURRENTLY " . $Ntime_out . " IN THE AFFTERNOON YOU CAN'T TIME OUT AT NOON_TIME!";
            }
            else if($Ntime_out > "17:59:59" && $Ntime_out < "22:00:00"){
                $errors["evening"] = "IT'S CURRENTLY " . $Ntime_out . " IN THE EVENING YOU CAN'T TIME OUT AT NOON_TIME!";
            }
            else if(($Ntime_out > "22:00:59" && $Ntime_out <= "23:59:59") || ($Ntime_out >= "00:00:00" && $Ntime_out < "07:00:00")){
                $errors["late-hour"] = "NO ATTENDANCE IN THIS HOUR!";
            }
            if ($time_Out !== NULL && $attendance_At == date('Y-m-d')) {
                $errors["empty"] = "You've already made an attendance in this time!";
            }  

            if($errors){
                $_SESSION["time_errors"] = $errors;
                header("Location: ../attendance/attendance.php");
                die();
            }else{
            
            $query = "INSERT INTO attendance (Ntime_out, members_id) VALUES (:current_time, :member_id)";
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
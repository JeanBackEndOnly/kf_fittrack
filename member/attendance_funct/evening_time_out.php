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
        $time_Out = isset($time_out["Etime_out"]) ? $time_out["Etime_out"] : null;
        $attendance_At = isset($time_out["attendance_at"]) ? $time_out["attendance_at"] : null;
    }
} else {
    die("No member ID found");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $Etime_out = $_POST["Etime_out"];
        try{
        
            $query = "SELECT * FROM attendance WHERE members_id = :members_id;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":members_id", $members_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $errors = [];

            if($Etime_out > "06:59:59" && $Etime_out < "12:00:00"){
                $errors["afterNoon"] = "IT'S CURRENTLY " . $Etime_out . " IN THE MORNING YOU CAN'T TIME OUT AT EVENING!";
            }
            else if($Etime_out > "11:59:59" && $Etime_out < "01:00:00"){
                $errors["noon"] = "IT'S CURRENTLY " . $Etime_out . " IN THE NOON_TIME YOU CAN'T TIME OUT AT EVENING!";
            }
            else if($Etime_out > "12:59:59" && $Etime_out < "18:00:00"){
                $errors["afterNoon"] = "IT'S CURRENTLY " . $Etime_out . " IN THE AFFTERNOON YOU CAN'T TIME OUT AT EVENING!";
            }
            else if(($Etime_out > "22:00:59" && $Etime_out <= "23:59:59") || ($Etime_out >= "00:00:00" && $Etime_out < "07:00:00")){
                $errors["late-hour"] = "NO ATTENDANCE IN THIS HOUR!";
            }
            else if (!empty($time_Out) && isset($attendance_At) && $attendance_At == date('Y-m-d')) {
                $errors["empty"] = "You've already made an attendance in this time!";
            }  

            if($errors){
                $_SESSION["time_errors"] = $errors;
                header("Location: ../attendance/attendance.php");
                die();
            }else{
            
            $query = "INSERT INTO attendance (Etime_out, members_id) VALUES (:current_time, :member_id)";
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
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
        $time_In = isset($time_out["Etime_in"]) ? $time_out["Etime_in"] : null;
        $attendance_At = isset($time_out["attendance_at"]) ? $time_out["attendance_at"] : null;
    }
} else {
    die("No member ID found");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $Etime_in = $_POST["Etime_in"];

        try{

            $errors = [];

            if($Etime_in > "06:59:59" && $Etime_in < "12:00:00"){
                $errors["afterNoon"] = "IT'S CURRENTLY " . $Etime_in . " IN THE MORNING YOU CAN'T TIME OUT AT EVENING!";
            }
            else if($Etime_in > "11:59:59" && $Etime_in < "01:00:00"){
                $errors["noon"] = "IT'S CURRENTLY " . $Etime_in . " IN THE NOON_TIME YOU CAN'T TIME OUT AT EVENING!";
            }
            else if($Etime_in > "12:59:59" && $Etime_in < "18:00:00"){
                $errors["afterNoon"] = "IT'S CURRENTLY " . $Etime_in . " IN THE AFFTERNOON YOU CAN'T TIME OUT AT EVENING!";
            }
            else if(($Etime_in > "22:00:59" && $Etime_in <= "23:59:59") || ($Etime_in >= "00:00:00" && $Etime_in < "07:00:00")){
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
            
            $query = "INSERT INTO attendance (Etime_in, members_id) VALUES (:current_time, :member_id)";
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
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
        $time_In = isset($time_out["Atime_in"]) ? $time_out["Atime_in"] : null;
        $attendance_At = isset($time_out["attendance_at"]) ? $time_out["attendance_at"] : null;
    }
} else {
    die("No member ID found");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $Atime_in = $_POST["Atime_in"];

        try{

            $errors = [];

            if($Atime_in > "06:59:59" && $Atime_in < "12:00:00"){
                $errors["morning"] = "IT'S CURRENTLY " . $Atime_in . " IN THE MORNING YOU CAN'T TIME OUT AT AFTERNOON!";
            }
            else if($Atime_in > "11:59:59" && $Atime_in < "01:00:00"){
                $errors["noon"] = "IT'S CURRENTLY " . $Atime_in . " IN THE NOON_TIME YOU CAN'T TIME OUT AT AFTERNOON!";
            }
            else if(($Atime_in > "22:00:59" && $Atime_in <= "23:59:59") || ($Atime_in >= "00:00:00" && $Atime_in < "07:00:00")){
                $errors["late-hour"] = "NO ATTENDANCE IN THIS HOUR!";
            }
            else if($Atime_in > "17:59:59" && $Atime_in < "22:00:00"){
                $errors["evening"] = "IT'S CURRENTLY " . $Atime_in . " IN THE EVENING YOU CAN'T TIME OUT AT AFTERNOON!";
            }
            else if (!empty($time_In) && isset($attendance_At) && $attendance_At == date('Y-m-d')) {
                $errors["empty"] = "You've already made an attendance in this time!";
            }  


            if($errors){
                $_SESSION["time_errors"] = $errors;
                header("Location: ../attendance/attendance.php");
                die();
            }else{
            
            $query = "INSERT INTO attendance (Atime_in, members_id) VALUES (:current_time, :member_id)";
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
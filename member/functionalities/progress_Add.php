<?php
require_once '../../include/config.php';
require_once '../../include/session.php';
require_once '../functionalities/control.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $day = $_POST["day"];
    $date = $_POST["date"];
    $workout_day = $_POST["workout_day"];
    $exercise = isset($_POST["exercise"]) ? implode(',', $_POST["exercise"]) : null;
    $member_id = intval($_POST["member_id"]);
    
    if (isset($_FILES["image_file"]) && $_FILES["image_file"]["error"] === 0) {
        $image = $_FILES["image_file"];
        
        
        $errors = [];
        if(empty_image($image)){
            $errors["image_Empty"] = "PLease insert your progress image!";
        }
        if(fileSize_notCompatible($image)){
            $errors["large_File"] = "The image must not exceed to 5mb!";
        }

        $allowed_types = ["image/jpeg", "image/jpg", "image/png"];
        if(image_notCompatible($image, $allowed_types)){
            $errors["file_Types"] = "Only JPG, JPEG, and PNG files are allowed.";
        }

        $target_dir = "../../upload_images/";
        $image_file_name = uniqid() . "-" . basename($image["name"]);
        $target_file = $target_dir . $image_file_name;

        if(file_notUploaded($image, $target_file)){
            $errors["upload_Error"] = "There was an error uploading your image.";
        }

        if($errors){

            print_r($errors);
            $_SESSION["image_errors"] = $errors;
            header("Location: ../progress/index_progress.php");
            die();
        }

    } else {
        header("Location: ../progress/index_progress.php");
        die();
    }

    try {
        $query = "INSERT INTO progress (members_id, date, day, workout_day, exercise, image_file) 
                  VALUES (:member_id, :date, :day, :workout_day, :exercise, :image_file);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":member_id", $member_id);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":day", $day);
        $stmt->bindParam(":workout_day", $workout_day);
        $stmt->bindParam(":exercise", $exercise);
        $stmt->bindParam(":image_file", $image_file_name);
        $stmt->execute();

        header("Location: ../progress/index_progress.php?progress=success");
        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../progress/index_progress.php");
    die();
}

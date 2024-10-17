<?php

require_once '../../include/config.php';
require_once '../../include/session.php';
require_once 'control.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $phone_no = $_POST["phone_no"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];
    $member_id = $_POST["member_id"];
    $current_profile_picture = $_POST["current_profile_picture"] ?? null;

    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] === 0) {
        $image = $_FILES["profile_picture"];
    
        try {
            $errors = [];
    
            // Define allowed types before using them
            $allowed_types = ["image/jpeg", "image/jpg", "image/png"];
    
            if (strpos($image["type"], 'video') !== false) {
                $errors["file_Types"] = "Videos are not allowed! Please upload an image (JPG, JPEG, PNG).";
            } else {
                if (image_notCompatible($image, $allowed_types)) {
                    $errors["file_Types"] = "Only JPG, JPEG, and PNG files are allowed.";
                }
            }
    
            if (empty_image($image)) {
                $errors["image_Empty"] = "Please insert your profile image!";
            }
            if (fileSize_notCompatible($image)) {
                $errors["large_File"] = "The image must not exceed 5 MB!";
            }
    
            $target_dir = "../../upload_images/";
            $image_file_name = uniqid() . "-" . basename($image["name"]);
            $target_file = $target_dir . $image_file_name;
    
            if (file_notUploaded($image, $target_file)) {
                $errors["upload_Error"] = "There was an error uploading your image.";
            }
    
            if ($errors) {
                $_SESSION["input_errors"] = $errors;
                header("Location: edit_index.php?member_id=" . $member_id);
                die();
            }
    
            edit_information($pdo, $fullName, $email, $address, $phone_no, $gender, $age, $image_file_name, $member_id);
    
            header("Location: ../profile/edit_index.php?edit=success&member_id=" . $member_id);
            die();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    
    } else {
        edit_information($pdo, $fullName, $email, $address, $phone_no, $gender, $age, $current_profile_picture, $member_id);
        
        // Redirect on success
        header("Location: ../profile/edit_index.php?edit=success&member_id=" . $member_id);
        die();
    }
} else {
    header("Location: ../profile/edit_index.php?member_id=" . $member_id);
    die();
}

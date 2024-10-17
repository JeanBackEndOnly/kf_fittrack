<?php
require_once '../../include/config.php';
require_once 'all_model.php';
require_once 'all_cntrl.php';
require_once '../../include/session.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $fullName = $_POST["fullName"];
    $address = $_POST["address"];
    $phone_no =  $_POST["phone_no"];
    $gender = $_POST["gender"];
    $age = intval($_POST["age"]);
    $confirm_password = $_POST["confirm_password"];

    try {
        $errors = []; 

        if(empty_inputs($username, $password, $email, $fullName, $address, $phone_no, $gender, $age)){
            $errors["empty_inputs"] = "Fill all fields!";
        }
        if(invalid_email($email)){
            $errors["invalid_email"] = "invalid email!";
        }
        if(username_taken($pdo, $username)){
            $errors["username_taken"] = "username already taken!";
        }
        if(email_registered($pdo, $email)){
            $errors["email_registered"] = "email already registered!";
        }
        if(confirm_password($confirm_password, $password)){
            $errors["password_not_matched"] = "Password Not Matched!";
        }

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;
            $signup_data = [
                "username" => $username,
                "email" => $email,
                "fullName" => $fullName,
                "address" => $address,
                "phone_no" => $phone_no,
                "gender" => $gender,
                "age" => $age
            ];
            $_SESSION["user_signup"] = $signup_data;
            header("Location: ../membership/register_Index.php");
            die();
        }

        getUserIpnput($pdo, $username, $password, $fullName, $email, $address, $phone_no, $gender, $age);

        header("Location: ../membership/register_Index.php?signup=success");

        $stmt = null;
        $pdo = null;

        die();
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}else{
    header("Location: ../membership/register_Index.php");
    die();
}
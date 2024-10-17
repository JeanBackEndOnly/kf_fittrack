<?php

require_once '../../include/config.php';
require_once '../../include/session.php';
require_once '../functionalities/model.php';
require_once '../functionalities/control.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION["user_id"];
    $current_Password = $_POST["current_Password"];
    
    try {
        $errors = [];
        if (password_NotMatched($pdo, $id, $current_Password)) {
            $errors["wrong_Password"] = "Wrong password!";
        }

        if ($errors) {
            $_SESSION["wrong_Password"] = $errors;
            header("Location: ../profile/password_index.php");
            die();
        } else {
            header("Location: ../profile/password_index.php?correct=password");
            die();
        }
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
} else {
    header("Location: ../profile/password_index.php");
    exit;
}


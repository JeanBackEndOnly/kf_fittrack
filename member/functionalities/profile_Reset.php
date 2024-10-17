<?php
require_once '../../include/config.php';
require_once '../../include/session.php';
require_once '../functionalities/control.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = $_SESSION["user_id"];
    $new_Password = $_POST["new_Password"];
    $confirm_Password = $_POST["confirm_Password"];

    try {
        $errors = [];

        if(confirm_password($confirm_Password, $new_Password)){
            $errors["password_notMatch"] = "Password Not Match";
        }
        if($errors){
            $_SESSION["password_notMatch"] = $errors;
            header("Location: ../profile/reset_Password.php");
            die();
        }

        reset_password($pdo, $new_Password, $id);

        header("Location: ../profile/reset_Password.php?reset=success");

        $pdo=null;
        $stmt=null;

        die();
    } catch (PDOException $e) {
       die("Query Failed: " .$e->getMessage());
    }

} else {
    header("Location: ../profile/reset_Password.php");
    die();
}
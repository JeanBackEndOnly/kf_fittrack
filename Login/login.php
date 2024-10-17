<?php

require_once '../include/config.php';
require_once 'login_model.php';
require_once 'login_cntrl.php';
require_once '../include/session.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {

        $errors = []; 

        if(empty_inputs($username, $password)){
            $errors["empty_inputs"] = "Fill all fields!";
        }

        $result = get_username($pdo, $username);

        if(wrong_username($result)){
            $errors["login_incorrect"] = "Incorrect login info!";
        }
        if(!wrong_username($result) && wrong_password($password, $result["password"])){
            $errors["login_incorrect"] = "wrong password!";
        }

        if ($errors) {
            $_SESSION["errors_login"] = $errors;
            
            header("Location: ../index.php");
            die();
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["id"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);
        $_SESSION["roles"] = $result["user_Role"];

        $_SESSION["last_regeneration"] = time();

        if($_SESSION["roles"] == "members"){
            header("Location: ../member/dashboard/dashboard.php");
        }else if($_SESSION["roles"] == "admin"){
            header("Location: ../Admin/dashboard/dashboard_index.php");
        }
        

        $pdo = null;
        $stmt = null;

        die();
        
    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}else{
    header("Location: ../../index.php");
    die();
}
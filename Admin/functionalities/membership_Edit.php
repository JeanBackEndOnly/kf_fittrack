<?php

require_once '../../include/config.php';
require_once '../../include/session.php';
require_once 'all_cntrl.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["member_id"])) {
        $member_id = intval($_POST["member_id"]);
    } else {
        echo "Member ID not provided.";
        die();
    }

    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $phone_no = $_POST["phone_no"];
    $gender = $_POST["gender"];
    $age = intval($_POST["age"]);
    $users_id = intval($_POST["users_id"]);

    try {
        $errors = [];

        if(Inputs_empty($fullName, $email, $address, $phone_no, $gender, $age)){
            $errors["inputs_empty"] = "Pleas Fill All Fields!";
        }
        if(invalid_email($email)){
            $errors["invalid_email"] = "Email Invalid!";
        }

        if ($errors) {
        $_SESSION["errors_input"] = $errors;
        header("Location: edit_index.php?member_id=" . $member_id);
        die();
    }

        edit_MemberInfo($pdo, $users_id, $fullName, $email, $address, $phone_no, $gender, $age);
        header("Location: ../membership/edit_Index.php?edit=success&member_id=" . $member_id);

        $stmt = null;
        $pdo = null;

        die();

    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}else {
    header("Location: ../membership/edit_Index.php");
    die();
}
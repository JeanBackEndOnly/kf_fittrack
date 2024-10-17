<?php

require_once '../../include/config.php';
require_once '../../include/session.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $members_id = $_POST["members_id"];
    $plans_id = $_POST["plans_id"];

    if($members_id && $plans_id){
        $query = "DELETE FROM plans WHERE plans_id = :plans_id AND members_id = :members_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":plans_id", $plans_id);
        $stmt->bindParam(":members_id", $members_id);
        $stmt->execute();

        header("Location: ../plans/plans.php?delete=sucess");

        $stmt = null;
        $pdo = null;

        die();
    }else{
        echo "this plan does not exist!";
    }
    
}else{
    header("Location: ../plans/view_plans.php");
    die();
}

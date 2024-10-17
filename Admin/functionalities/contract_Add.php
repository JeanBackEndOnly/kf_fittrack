<?php

require_once '../../include/config.php';
require_once '../../include/session.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $members_id = intval($_POST["members_id"]);
    $contract_Renewal = $_POST["contract_Renewal"];
    $contract_Expiration = $_POST["contract_Expiration"];
    
    try {   
        $query = "DELETE FROM contract WHERE members_id= :members_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":members_id", $members_id);
        $stmt->execute();

        $query = "INSERT INTO contract (members_id, contract_Renewal, contract_Expiration) VALUES
        (:members_id, :contract_Renewal, :contract_Expiration);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":members_id", $members_id);
        $stmt->bindParam(":contract_Renewal", $contract_Renewal);
        $stmt->bindParam(":contract_Expiration", $contract_Expiration);
        $stmt->execute();

        header("Location: ../contract/add_Index.php?contract=success&members_id=" . $members_id);
        
        $stmt = null;
        $pod = null;

        die();

    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}else{
    header("Location: ../contract/add_Index.php");
    die();
}
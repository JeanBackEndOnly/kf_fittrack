<?php

require_once '../../include/config.php';
require_once '../../include/session.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $progress_id = $_POST["progress_id"];

    try {
        
        $query = "DELETE FROM progress WHERE progress_id = :progress_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":progress_id", $progress_id);
        $stmt->execute();

        header("Location: ../progress/progress.php?delete=sucess");

    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
}else{
    header("Loaction: ../progress/view_progress.php");
    di();
}
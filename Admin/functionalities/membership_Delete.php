<?php
require_once "../../include/config.php";
require_once "../../include/session.php";

$member_id = isset($_GET["member_id"]) ? $_GET["member_id"] : "no member_id found<br>";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo"<br>";
    echo $id = $_POST['id'] ?? null;
    echo"<br>";
    echo $member_id = $_POST['member_id'] ?? null;
    echo"<br>";
    echo $contract_id = $_POST['contract_id'] ?? null;
    echo"<br>";

    if($contract_id !== ""){
        header("Location: ../membership/membership_Index.php?contract=exist&members_id=" . $member_id);
    }
    else if ($id && $member_id) {
        if (isset($contract_id) !== "") {
            $query = "DELETE FROM members WHERE member_id = :member_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":member_id", $member_id);
            $stmt->execute();

            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            $query = "DELETE FROM contract WHERE contract_id = :contract_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":contract_id", $contract_id);
            $stmt->execute();  
            
            header("Location: ../membership/membership_Index.php?deleted=successfully");

            $stmt = null;
            $pdo = null;

            die();
        } else {
            $query = "DELETE FROM members WHERE member_id = :member_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":member_id", $member_id);
            $stmt->execute();

            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            
            header("Location: ../membership/membership_Index.php?deleted=successfully");

            $stmt = null;
            $pdo = null;

            die();
        }
    } else {
        echo "ID or Member ID not provided.";
    }
}
?>

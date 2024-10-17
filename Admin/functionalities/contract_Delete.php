<?php
require_once "../../include/config.php";
require_once "../../include/session.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $members_id = $_POST['members_id'] ?? null;

    if ($members_id) {
        $query = "DELETE FROM contract WHERE members_id = :members_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":members_id", $members_id);
        $stmt->execute();

        header("Location: ../contract/contract_Index.php?deletedContract=sucessfully&member_id" . $member_id);

        $pdo = null;
        $stmt = null;

        die();
    } else {
        header("Location: ../contract/contract_Index.php?no=contract&members_id=" . $member_id);
    }
}
?>

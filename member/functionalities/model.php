<?php

declare(strict_types=1);

function get_Password(object $pdo, int $id) {
    $query = "SELECT password FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
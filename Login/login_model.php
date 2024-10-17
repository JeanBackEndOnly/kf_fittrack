<?php

declare(strict_types=1);

// function get_username(object $pdo, String $username){
//     $query = "SELECT * FROM users WHERE username = :username;";
//     $stmt = $pdo->prepare($query);
//     $stmt->bindParam(":username", $username);
//     $stmt->execute();

//     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     return $result;
// }
function get_username($pdo, $username) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

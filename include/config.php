<?php

$host = 'localhost';
$dbname = 'fittrack_db';
$dbusername = 'root';
$dbpassword = '';

try {
    $pdo = new pdo("mysql:host=$host;dbname=$dbname;", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}

date_default_timezone_set('Asia/Manila');
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
$current_time = date('H:i:s');
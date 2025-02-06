<?php
$sdn = "mysql:host=localhost;dbname=lamps_store";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($sdn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

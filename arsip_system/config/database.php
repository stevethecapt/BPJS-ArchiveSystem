<?php

$host = "localhost";
$username = "root";
$password = "12345";   
$dbname = "arsip_system"; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    die("Koneksi gagal: " . $e->getMessage());
}
?>

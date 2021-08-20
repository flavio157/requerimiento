<?php
$host = 'localhost';
$dbname = 'reclamo';
$username = 'root';
$password = '';
 
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $pe) {
    die($pe->getMessage());
}
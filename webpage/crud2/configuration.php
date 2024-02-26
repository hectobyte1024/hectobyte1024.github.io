<?php
$host = 'localhost';
$port = '5432';
$dbname = 'database1';
$username = 'your_username';
$password = 'your_password';

try{
    $pdo = new PDO("pgsql:host=$host; dbname=$dbname", $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
}catch (PDOException $e){
    die("Connection failed: " . $e->getMessage());
}
?>
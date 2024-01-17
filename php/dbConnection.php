<?php
$user = "root";
$pass = "";
try {
    $pdo = new PDO("mysql:host=localhost;dbname=bookdata", $user, $pass);
} catch (PDOException $e) {
    echo $e->getMessage();
}
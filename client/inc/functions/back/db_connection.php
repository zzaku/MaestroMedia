<?php
$db_host = 'localhost';
$db_user = 'maestromedia';
$db_pass = '!Maestromedia!2023';
$db_name = 'maestromedia';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur lors de la connexion : " . $e->getMessage());
}
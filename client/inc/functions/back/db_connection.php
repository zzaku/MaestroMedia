<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'nhSYC95Db553br';
$db_name = 'maestromedia';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur lors de la connexion : " . $e->getMessage());
}
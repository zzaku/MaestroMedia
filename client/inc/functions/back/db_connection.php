<?php
$db_host = 'cutmyl1nk.fr';
$db_user = 'u380325924_rootmedia';
$db_pass = '9l*WqA/f!F';
$db_name = 'u380325924_maestromedia';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur lors de la connexion : " . $e->getMessage());
}
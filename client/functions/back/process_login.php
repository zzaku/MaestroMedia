<?php
session_start();
include 'db_connection.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT password FROM utilisateur WHERE email = ?");
$stmt->execute([$email]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && password_verify($password, $row['password'])) {
    $_SESSION['loggedin'] = true;
    header('Location: ../pages/index.php');
    exit;
} else {
    header('Location: login.php?error=1');
    exit;
}

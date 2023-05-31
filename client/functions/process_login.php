<?php
session_start();
include 'db_connection.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
$stmt->execute([$username]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && password_verify($password, $row['password'])) {
    $_SESSION['loggedin'] = true;
    header('Location: ../pages/index.php');
    exit;
} else {
    header('Location: login.php?error=1');
    exit;
}

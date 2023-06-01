<?php
function signIn() {

    include 'db_connection.php';
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['user'] = $row; // Stock all user information in the session
        unset($_SESSION['user']['password']); // For security reasons, do not store password in session
        header('Location: ./index.php?page=home');
        exit;
    } else {
        header('Location: ./pages/login/login.php?error=1');
        header('Location: ./index.php?page=home&error=1');

        exit;
    }
}


<?php
session_start();
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: ../functions/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Accueil</title>
</head>
<body>
  <p>Bienvenue, vous êtes connecté !</p>
  <a href="logout.php">Déconnexion</a>
</body>
</html>

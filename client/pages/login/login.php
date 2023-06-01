<?php
require_once('./inc/functions/back/process_login.php');
if(isset($_POST['submit'])) {
    signIn();
}
?>
  <form action="" method="post">
    <label for="email">Adresse e-mail :</label>
    <input type="email" id="email" name="email">

    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password">

    <input type="submit" name="submit" value="Connexion">
  </form>

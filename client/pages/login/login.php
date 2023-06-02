<?php
require_once('./inc/functions/back/process_login.php');
if(isset($_POST['submit'])) {
    signIn();
}
?>
 <form action="" method="post" class="login-form">
  <label for="email" class="form-label">Adresse e-mail :</label>
  <input type="email" id="email" name="email" class="form-input">

  <label for="password" class="form-label">Mot de passe :</label>
  <input type="password" id="password" name="password" class="form-input">

  <input type="submit" name="submit" value="Connexion" class="form-button">
</form>


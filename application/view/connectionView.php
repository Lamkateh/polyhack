<?php $title ='Connexion'; ?>

<?php ob_start(); ?>

<div class="container connection-page">
  <div class="connection-container">
    <h1>Connexion</h1>
    <form class="" action="index.php?action=connectionProcess" method="post">
      <div class="group">
        <label for="usernameInput">Nom d'utilisateur</label><br>
        <input type="text" id="usernameInput" name="username" required>
      </div>
      <div class="group">
        <label for="passwordInput">Mot de passe</label><br>
        <input type="password" id="passwordInput" name="password" required>
      </div>
      <?php if(isset($_GET['passwordIncorrect']) && $_GET['passwordIncorrect']) { ?>
        <div class="group">
          Nom d'utilisateur ou mot de passse incorrect.
        </div>
      <?php } ?>
      <div class="group">
        <input class="btn" type="submit" value="Se connecter">
      </div>
    </form>

  </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('../application/view/template.php'); ?>

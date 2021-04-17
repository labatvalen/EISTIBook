<?php
session_start();
?>
<!--page de login-->
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Site</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='connexion.css' rel="stylesheet" type="text/css">
</head>
<body>
  <?php
  require("util.php");

  error_reporting(-1);
  ini_set('display_errors', 'On');

  if (isset($_POST['Connexion'])) {
    if (tryLogin($_POST)) {
      header('Location: filactu.php');
      exit();
    } else {
        echo '<?php
        session_destroy();
        $_SESSION=[];?>
        <div id="titre">
            EISTIBOOK
        </div>
        <form action="connectinscrip.php" method="POST">
        Log in
          <div class="contenu">
            <div class="champ">
              <input type="email" class="form-control" id="email" name="email" placeholder="Adresse mail">
            </div>
            <div class="champ">
              <input type="password" class="form-control" id="password" name="password" placeholder="Mot de Passe">
            </div>
            <div class="champ">
                <button type="submit" name="Connexion">Connexion</button>
            </div>
          </div>
        </form>
        <div id="erreur">
          Identifiants incorrects !
        </div>
        <div class="contenu">
          <div class="champ">
              <input type="button" name="Inscription" onclick="document.location.href=\'inscription.php\'" value="S\'inscrire"/>
          </div>
        </div>';
      }
    } else {
      echo '<?php
      session_destroy();
      $_SESSION=[];?>
      <div id="titre">
          EISTIBOOK
      </div>
      <form action="connectinscrip.php" method="POST">
      Log in
        <div class="contenu">
          <div class="champ">
            <input type="email" class="form-control" id="email" name="email" placeholder="Adresse mail">
          </div>
          <div class="champ">
            <input type="password" class="form-control" id="password" name="password" placeholder="Mot de Passe">
          </div>
          <div class="champ">
              <button type="submit" name="Connexion">Connexion</button>
          </div>
        </div>
      </form>
      <div class="contenu">
        <div class="champ">
            <input type="button" class="boutton" name="Inscription" onclick="document.location.href=\'inscription.php\'" value="S\'inscrire"/>
        </div>
      </div>';
    }
        ?>
      </body>
      </html>

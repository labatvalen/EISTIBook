<?php
  session_start();
?>
<!--page d'inscription-->
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Site</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="traitement.js"></script>
    <link href='forme.css' rel="stylesheet" type="text/css">
</head>
<body>
  <?php
  require("util.php");



  error_reporting(-1);
  ini_set('display_errors', 'On');

  if (isset($_POST['Inscription'])) {
    if (tryInscription($_POST)==1) {
      echo 'Inscription réussie !
      <a href="connectinscrip.php">Revenir à la page de connexion</a>';
    } elseif (tryInscription($_POST)==-1) {
      echo '
      les deux mots de passe entres sont differents
      <div id="titre">
        EISTIBOOK
      </div>
      <div id="soustitre">
        Inscription
      </div>
      <form action="inscription.php" method="POST">
        <div class="contenu">
          <div class="champ">
            Prenom : <input id="prenom" name="prenom" placeholder="Prénom">
          </div>
          <div class="champ">
            Nom : <input id="nom" name="nom" placeholder="Nom">
          </div>
          <div class="champ">
            Date de naissance : <input type="date" id="bday" name="bday">
          </div>
          <div class="champ">
            Sexe : <input type="radio" value="homme" name="gender" id="homme" checked onclick="propre1()">Homme
            <input type="radio" value="femme" name="gender" id="femme" onclick="propre1()">Femme
            <input type="radio" value="autre" name="gender" id="autre" onclick="propre1()">Autre
          </div>
          <div class="champ">
            Numéro de téléphone : <input id="tel" name="tel" placeholder="Téléphone">
          </div>
          <div class="champ">
            Adresse mail : <input id="mail" name="mail" placeholder="Mail">
          </div>
          <div class="champ">
            Mot de passe : <input type="password" id="mdp" name="mdp" placeholder="Mot de passe">
          </div>
          <div class="champ">
            Confirmation mot de passe : <input type="password" id="mdpc" name="mdpc" placeholder="Mot de passe">
          </div>
          <div class="champ">
          Choisir ma propre photo<input type="checkbox" id="prop" name="propr" onchange="propre()" checked/>
            <div id="ava">
            <input id="fileToUpload" type="file" name="fileToUpload" /><input type="button" name="go" value="Choisir" onclick="execution()"/>
            </div>
            <div id="test"></div>
            </div>
        </div>
        <div class="champ">
            <button type="submit" name="Inscription">S\'inscrire</button>
        </div>
      </form>
      <br>
      <div class="champ">
          <input type="button" value="Retour" onclick="document.location.href=\'connectinscrip.php\'">
      </div>
      </div>';
    } elseif (tryInscription($_POST)==-2) {
      echo '
      l\'adresse mail est déjà utilisée
      <div id="titre">
        EISTIBOOK
      </div>
      <div id="soustitre">
        Inscription
      </div>
      <form action="inscription.php" method="POST">
        <div class="contenu">
          <div class="champ">
            Prenom : <input id="prenom" name="prenom" placeholder="Prénom">
          </div>
          <div class="champ">
            Nom : <input id="nom" name="nom" placeholder="Nom">
          </div>
          <div class="champ">
            Date de naissance : <input type="date" name="bday">
          </div>
          <div class="champ">
            Sexe : <input type="radio" value="homme" name="gender" id="homme" checked onclick="propre1()">Homme
            <input type="radio" value="femme" name="gender" id="femme" onclick="propre1()">Femme
            <input type="radio" value="autre" name="gender" id="autre" onclick="propre1()">Autre
          </div>
          <div class="champ">
            Numéro de téléphone : <input id="tel" name="tel" placeholder="Téléphone">
          </div>
          <div class="champ">
            Adresse mail : <input id="mail" name="mail" placeholder="Mail">
          </div>
          <div class="champ">
            Mot de passe : <input type="password" id="mdp" name="mdp" placeholder="Mot de passe">
          </div>
          <div class="champ">
            Confirmation mot de passe : <input type="password" id="mdpc" name="mdpc" placeholder="Mot de passe">
          </div>
          <div class="champ">
          Choisir ma propre photo<input type="checkbox" id="prop" name="propr" onchange="propre()" checked/>
            <div id="ava">
            <input id="fileToUpload" type="file" name="fileToUpload" /><input type="button" name="go" value="Choisir" onclick="execution()"/>
            </div>
            <div id="test"></div>
            </div>
        </div>
        <div class="champ">
            <button type="submit" name="Inscription">S\'inscrire</button>
        </div>
      </form>
      <div class="champ">
          <input type="button" value="Retour" onclick="document.location.href=\'connectinscrip.php\'">
      </div>
      </div>';
    } elseif (tryInscription($_POST)==-3) {
      echo '
      la date entrée n\'est pas correcte
      <div id="titre">
        EISTIBOOK
      </div>
      <div id="soustitre">
        Inscription
      </div>
      <form action="inscription.php" method="POST">
        <div class="contenu">
          <div class="champ">
            Prenom : <input id="prenom" name="prenom" placeholder="Prénom">
          </div>
          <div class="champ">
            Nom : <input id="nom" name="nom" placeholder="Nom">
          </div>
          <div class="champ">
            Date de naissance : <input type="date" id="bday" name="bday">
          </div>
          <div class="champ">
            Sexe : <input type="radio" value="homme" name="gender" id="homme" checked onclick="propre1()">Homme
            <input type="radio" value="femme" name="gender" id="femme" onclick="propre1()">Femme
            <input type="radio" value="autre" name="gender" id="autre" onclick="propre1()">Autre
          </div>
          <div class="champ">
            Numéro de téléphone : <input id="tel" name="tel" placeholder="Téléphone">
          </div>
          <div class="champ">
            Adresse mail : <input id="mail" name="mail" placeholder="Mail">
          </div>
          <div class="champ">
            Mot de passe : <input type="password" id="mdp" name="mdp" placeholder="Mot de passe">
          </div>
          <div class="champ">
            Confirmation mot de passe : <input type="password" id="mdpc" name="mdpc" placeholder="Mot de passe">
          </div>
          <div class="champ">
          Choisir ma propre photo<input type="checkbox" id="prop" name="propr" onchange="propre()" checked/>
            <div id="ava">
            <input id="fileToUpload" type="file" name="fileToUpload" /><input type="button" name="go" value="Choisir" onclick="execution()"/>
            </div>
            <div id="test"></div>
            </div>
        </div>
        <div class="champ">
            <button type="submit" name="Inscription">S\'inscrire</button>
        </div>
      </form>
      <div class="champ">
          <input type="button" value="Retour" onclick="document.location.href=\'connectinscrip.php\'">
      </div>
      </div>';
    } elseif (tryInscription($_POST)==-10) {
      echo '
      l\'adresse mail entrée n\'est pas correcte
      <div id="titre">
        EISTIBOOK
      </div>
      <div id="soustitre">
        Inscription
      </div>
      <form action="inscription.php" method="POST">
        <div class="contenu">
          <div class="champ">
            Prenom : <input id="prenom" name="prenom" placeholder="Prénom">
          </div>
          <div class="champ">
            Nom : <input id="nom" name="nom" placeholder="Nom">
          </div>
          <div class="champ">
            Date de naissance : <input type="date" id="bday" name="bday">
          </div>
          <div class="champ">
            Sexe : <input type="radio" value="homme" name="gender" id="homme" checked onclick="propre1()">Homme
            <input type="radio" value="femme" name="gender" id="femme" onclick="propre1()">Femme
            <input type="radio" value="autre" name="gender" id="autre" onclick="propre1()">Autre
          </div>
          <div class="champ">
            Numéro de téléphone : <input id="tel" name="tel" placeholder="Téléphone">
          </div>
          <div class="champ">
            Adresse mail : <input id="mail" name="mail" placeholder="Mail">
          </div>
          <div class="champ">
            Mot de passe : <input type="password" id="mdp" name="mdp" placeholder="Mot de passe">
          </div>
          <div class="champ">
            Confirmation mot de passe : <input type="password" id="mdpc" name="mdpc" placeholder="Mot de passe">
          </div>
          <div class="champ">
          Choisir ma propre photo<input type="checkbox" id="prop" name="propr" onchange="propre()" checked/>
            <div id="ava">
            <input id="fileToUpload" type="file" name="fileToUpload" /><input type="button" name="go" value="Choisir" onclick="execution()"/>
            </div>
            <div id="test"></div>
            </div>
        </div>
        <div class="champ">
            <button type="submit" name="Inscription">S\'inscrire</button>
        </div>
      </form>
      <div class="champ">
          <input type="button" value="Retour" onclick="document.location.href=\'connectinscrip.php\'">
      </div>
      </div>';

    } else {
      echo '
      veuillez remplir tous les champs pour pouvoir vous inscrire
    <div id="titre">
      EISTIBOOK
    </div>
    <div id="soustitre">
      Inscription
    </div>
    <form action="inscription.php" method="POST">
      <div class="contenu">
        <div class="champ">
          Prenom : <input id="prenom" name="prenom" placeholder="Prénom">
        </div>
        <div class="champ">
          Nom : <input id="nom" name="nom" placeholder="Nom">
        </div>
        <div class="champ">
          Date de naissance : <input type="date" name="bday">
        </div>
        <div class="champ">
          Sexe : <input type="radio" value="homme" name="gender" id="homme" checked onclick="propre1()">Homme
          <input type="radio" value="femme" name="gender" id="femme" onclick="propre1()">Femme
          <input type="radio" value="autre" name="gender" id="autre" onclick="propre1()">Autre
        </div>
        <div class="champ">
          Numéro de téléphone : <input id="tel" name="tel" placeholder="Téléphone">
        </div>
        <div class="champ">
          Adresse mail : <input id="mail" name="mail" placeholder="Mail">
        </div>
        <div class="champ">
          Mot de passe : <input type="password" id="mdp" name="mdp" placeholder="Mot de passe">
        </div>
        <div class="champ">
          Confirmation mot de passe : <input type="password" id="mdpc" name="mdpc" placeholder="Mot de passe">
        </div>
        <div class="champ">
        Choisir ma propre photo<input type="checkbox" id="prop" name="propr" onchange="propre()" checked/>
          <div id="ava">
          <input id="fileToUpload" type="file" name="fileToUpload" /><input type="button" name="go" value="Choisir" onclick="execution()"/>
          </div>
          <div id="test"></div>
          </div>
      </div>
      <div class="champ">
          <button type="submit" name="Inscription">S\'inscrire</button>
      </div>
    </form>
    <div class="champ">
        <input type="button" value="Retour" onclick="document.location.href=\'connectinscrip.php\'">
    </div>
    </div>';
    }
  } else {
      echo '
    <div id="titre">
      EISTIBOOK
    </div>
    <div id="soustitre">
      Inscription
    </div>
    <form action="inscription.php" method="POST">
      <div class="contenu">
        <div class="champ">
          Prenom : <input id="prenom" name="prenom" placeholder="Prénom">
        </div>
        <div class="champ">
          Nom : <input id="nom" name="nom" placeholder="Nom">
        </div>
        <div class="champ">
          Date de naissance : <input type="date" name="bday">
        </div>
        <div class="champ">
          Sexe : <input type="radio" value="homme" name="gender" id="homme" checked onclick="propre1()">Homme
          <input type="radio" value="femme" name="gender" id="femme" onclick="propre1()">Femme
          <input type="radio" value="autre" name="gender" id="autre" onclick="propre1()">Autre
        </div>
        <div class="champ">
          Numéro de téléphone : <input id="tel" name="tel" placeholder="Téléphone">
        </div>
        <div class="champ">
          Adresse mail : <input id="mail" name="mail" placeholder="Mail">
        </div>
        <div class="champ">
          Mot de passe : <input type="password" id="mdp" name="mdp" placeholder="Mot de passe">
        </div>
        <div class="champ">
          Confirmation mot de passe : <input type="password" id="mdpc" name="mdpc" placeholder="Mot de passe">
        </div>
        <div class="champ">
        Choisir ma propre photo<input type="checkbox" id="prop" name="propr" onchange="propre()" checked/>
          <div id="ava">
          <input id="fileToUpload" type="file" name="fileToUpload" /><input type="button" name="go" value="Choisir" onclick="execution()"/>
          </div>
          <div id="test"></div>
          </div>
      </div>
      <div class="champ">
          <button type="submit" name="Inscription">S\'inscrire</button>
      </div>
    </form>
    <div class="champ">
        <input type="button" value="Retour" onclick="document.location.href=\'connectinscrip.php\'">
    </div>
    </div>';
    }
  ?>
</body>
</html>

<?php
  session_start();
	require("core.php");

  $serveur="localhost";
  $identifiant="root";
  $mdp="";
  $bdd="projet";
?>
<!--page de modif de photo de profil-->
<!-- pas implémentée-->
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Site</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="traitement.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='forme.css' rel="stylesheet" type="text/css">
</head>
<body>
  <div class="menu_horizontal">
    <div class="logo">
        <img class="logo2" src="logo.png" nom="logo_eisti">
    </div>
    <div class="titre">
        EISTIBOOK
    </div>
    <div class="barre_de_recherche">
        <form action="#" method="POST" autocomplete="off">
            <input class="saisie" type="text" placeholder="Rechercher une personne"/>
            <button type="summit" action="#" class="bouton_de_recherche">
                <img src="loupe.png">Search
            </button>
        </form>
    </div>
</div>




<nav role="navigation">
    <div class="menuToggle">

        <input type="checkbox" />
        <div class="toggle">
            <span class="barre_toggle"></span>
            <span class="barre_toggle"></span>
            <span class="barre_toggle"></span>
        </div>
        <ul class="menu_vertical">
            <a href="#" onclick='document.location.href="profil.php"'><li>Profil</li></a>
            <a href="#"><li>Messages</li></a>
            <a href="#"><li>Notifications</li></a>
            <a href="#"><li>Paramètres</li></a>
            <a href="#" onclick='document.location.href="connectinscrip.php"'><li>Se déconnecter</li></a>
        </ul>
    </div>
</nav>








<div class="entete">Fil d'actualité</div><div class="carreG"></div><div class="rondG"></div><div class="carreD"></div><div class="rondD"></div>

  <br>

<!--- PAGE ------------------------------------------------>
  <div class="page">

    <div id="ava">
      <input id="fileToUpload" type="file" name="fileToUpload" /><input type="button" name="go" value="Choisir" onclick="execution()"/>
    </div>
    <br>
    <div>
      <input type="button" name="Modif" value="Modifier la photo" onclick="modifimg()">
    </div>
    <br>
    <div>
      <input type="button" onclick="document.location.href='profil.php'" value="Retour">
    </div>
<?php

?>
  </div>

</body>
</html>

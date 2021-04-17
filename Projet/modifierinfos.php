<?php
  session_start();
	require("core.php");

  $serveur="localhost";
  $identifiant="root";
  $mdp="";
  $bdd="projet";
?>
<!--page de modification de son profil-->
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Site</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="traitement.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='style1.css' rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Eisti'book</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="filactu.php">Accueil</a></li>
                <li><a href="messagerie.php"><span class="glyphicon glyphicon-envelope"></span></a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="notif.php">Notification</a></li>
                <li><a href="amis.php">Amis</a></li>
                <li><a href='connectinscrip.php'>Déconnexion</a></li>
            </ul>
            <form class="navbar-form navbar-left" method="get" action="recherche.php">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="search">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <ul id="i">
    </ul>
    <div class="container">
<?php
	$db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
	$boolRes = mysqli_select_db($db,$GLOBALS['bdd']);

	$mail = $_SESSION['email'];

	$val='';
  echo '<div><input type="button" onclick="document.location.href=\'modifphoto.php\'" value="Modifier ma photo de profil"></div><br>';
	$query = "SELECT * FROM Public WHERE mail=\"".$mail."\"";
	$result=mysqli_query($db,$query) or die('Request error: '.$query);
	if (mysqli_num_rows($result) >0) {
		while($row=mysqli_fetch_assoc($result)) {
      if ($row['sexe']=='Homme') {
        echo '<div>Nom : <input type="text" id="nom" placeholder=\''.$row["nom"].'\'></div><div>Prénom : <input type="text" id="prenom" placeholder=\''.$row["prenom"].'\'></div><div>Sexe : <input type="radio" value="homme" name="gender" id="homme" checked>Homme<input type="radio" value="femme" name="gender" id="femme">Femme<input type="radio" value="autre" name="gender" id="autre">Autre</div><div>Ville : <input type="text" id="ville" placeholder=\''.$row["ville"].'\'></div><div>Travail : <input type="text" id="travail" placeholder=\''.$row["job"].'\'></div><div>Date de naissance : <input type="text" id="ddn" placeholder=\''.$row["ddn"].'\'></div>';
      } elseif ($row['sexe']=='Femme') {
        echo '<div>Nom : <input type="text" id="nom" placeholder=\''.$row["nom"].'\'></div><div>Prénom : <input type="text" id="prenom" placeholder=\''.$row["prenom"].'\'></div><div>Sexe : <input type="radio" value="homme" name="gender" id="homme">Homme<input type="radio" value="femme" name="gender" id="femme" checked>Femme<input type="radio" value="autre" name="gender" id="autre">Autre</div><div>Ville : <input type="text" id="ville" placeholder=\''.$row["ville"].'\'></div><div>Travail : <input type="text" id="travail" placeholder=\''.$row["job"].'\'></div><div>Date de naissance : <input type="text" id="ddn" placeholder=\''.$row["ddn"].'\'></div>';
      } else {
			     echo '<div>Nom : <input type="text" id="nom" placeholder=\''.$row["nom"].'\'></div><div>Prénom : <input type="text" id="prenom" placeholder=\''.$row["prenom"].'\'></div><div>Sexe : <input type="radio" value="homme" name="gender" id="homme">Homme<input type="radio" value="femme" name="gender" id="femme">Femme<input type="radio" value="autre" name="gender" id="autre" checked>Autre</div><div>Ville : <input type="text" id="ville" placeholder=\''.$row["ville"].'\'></div><div>Travail : <input type="text" id="travail" placeholder=\''.$row["job"].'\'></div><div>Date de naissance : <input type="text" id="ddn" placeholder=\''.$row["ddn"].'\'></div>';
      }
    }
	}
  $query1 = "SELECT * FROM Privee WHERE email=\"".$mail."\"";
	$result1=mysqli_query($db,$query1) or die('Request error: '.$query1);
	if (mysqli_num_rows($result1) >0) {
		while($row1=mysqli_fetch_assoc($result1)) {
      $lg=strlen($row1['mdp']);
			echo '<br><div>Adresse mail : <input type="text" id="email" placeholder=\''.$row1["email"].'\'></div><br><div><input type="checkbox" id="changement" onclick="modifmdp()">Modifier mon mot de passe</div><div id="mdp"></div><br>';
		}
	}
deconnecterBDD($db);
?>
<div id='modif'>
<input type="button" value="Modifier" onclick="modifprofil()">
<input type="button" onclick="document.location.href='profil.php'" value="Retour">
<div id='confirmation'></div>
</div>
    </div>

  </body>
</html>

<?php
  session_start();
	require("core.php");

  $serveur="localhost";
  $identifiant="root";
  $mdp="";
  $bdd="projet";
?>
<!-- affichage du profil-->
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
    <div class="col-md-6 gedf-main" id="publier">
            <input type="text" id="publication_content" placeholder="Publier quelque chose...">
            <?php echo '<input type="button" value="publier" onclick="publierFA('.$_SESSION['id'].')">';?>
            <!--<input id="fileToUpload" type="file" name="fileToUpload">-->
            <div id="test"></div>
        </div>
    <div class="container">
<?php
	$db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
	$boolRes = mysqli_select_db($db,$GLOBALS['bdd']);

	$mail = $_SESSION['email'];
  $lg=0;
  $code='';
	$val='';

  $querya="SELECT * FROM Image WHERE idImage=(SELECT Idpdp FROM Public WHERE mail='".$mail."')";
  $resulta=mysqli_query($db,$querya) or die('Request error: '.$querya);
  if (mysqli_num_rows($resulta) >0) {
		while($rowa=mysqli_fetch_assoc($resulta)) {
			echo '<div>Photo de profil : <img src="images/'.$rowa["nom"].'.'.$rowa["type"].'"/></div>';
		}
	}

	$query = "SELECT * FROM Public WHERE mail=\"".$mail."\"";
	$result=mysqli_query($db,$query) or die('Request error: '.$query);
	if (mysqli_num_rows($result) >0) {
		while($row=mysqli_fetch_assoc($result)) {
			echo '<div>Nom : '.$row["nom"].'</div><div>Prénom : '.$row["prenom"].'</div><div>Sexe : '.$row["sexe"].'</div>'.'<div>Ville : '.$row["ville"].'</div><div>Travail : '.$row["job"].'</div><div>Date de naissance : '.$row["ddn"].'</div>';
		}
	}
  $query1 = "SELECT * FROM Privee WHERE email=\"".$mail."\"";
	$result1=mysqli_query($db,$query1) or die('Request error: '.$query1);
	if (mysqli_num_rows($result1) >0) {
		while($row1=mysqli_fetch_assoc($result1)) {
      $lg=strlen($row1['mdp']);
      for ($i=0; $i < $lg; $i++) {
        $code=$code.'•';
      }
			echo '<br><div>Adresse mail : '.$row1["email"].'</div><div>Mot de passe : '.$code.'</div><br>';
		}
	}

deconnecterBDD($db);
?>
<div id='modif'>
<input type="button" onclick="document.location.href='modifierinfos.php'" value="Modifier mes informations">
</div>
    </div>

  </body>
</html>

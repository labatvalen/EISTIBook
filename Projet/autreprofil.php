<?php
  session_start();
//Page qui traite l'affichage du profil des autres. Appelée dans le fichier javascript traitement.js (pas fonctionnelle)
?>
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Site</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="traitement.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link href='style1.css' rel="stylesheet" type="text/css">
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
  require("core.php");

  $serveur="localhost";
  $identifiant="root";
  $mdp="";
  $bdd="projet";

  $mail = $_SESSION['email'];
  $lg=0;
  $code='';
  $val='';
  $idautre="";
  $nomautre=$_SESSION['nomautre'];

  $prenomautre=$_SESSION['prenomautre'];
  $id=$_SESSION['id'];
  $ami1=false;
  $ami2=false;

  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);

  $query1="SELECT * FROM Public WHERE nom='".$nomautre."' AND prenom='".$prenomautre."'";
  $result1=mysqli_query($db,$query1) or die('Request error: '.$query1);
  if (mysqli_num_rows($result1) >0) {
    while($row1=mysqli_fetch_assoc($result1)) {
      $idautre=$row1['idPublic'];
    }
  }

  $query2="SELECT * FROM Amis WHERE idAmi1='".$id."' AND idAmi2='".$idautre."'";
  $result2=mysqli_query($db,$query2) or die('Request error: '.$query2);
  if (mysqli_num_rows($result2) >0) {
    $ami1=true;
  }

  $query3="SELECT * FROM Amis WHERE idAmi2='".$id."' AND idAmi1='".$idautre."'";
  $result3=mysqli_query($db,$query3) or die('Request error: '.$query3);
  if (mysqli_num_rows($result3) >0) {
    $ami2=true;
  }

  if ($ami1 or $ami2) {
    $querya="SELECT * FROM Image WHERE idImage=(SELECT Idpdp FROM Public WHERE idPublic='".$idautre."')";
    $resulta=mysqli_query($db,$querya) or die('Request error: '.$querya);
    if (mysqli_num_rows($resulta) >0) {
      while($rowa=mysqli_fetch_assoc($resulta)) {
        echo '<div>Photo de profil : <img src="images/'.$rowa["nom"].'.'.$rowa["type"].'"/></div>';
      }
    }

    $query = "SELECT * FROM Public WHERE idPublic=\"".$idautre."\"";
    $result=mysqli_query($db,$query) or die('Request error: '.$query);
    if (mysqli_num_rows($result) >0) {
      while($row=mysqli_fetch_assoc($result)) {
        echo '<div>Nom : '.$row["nom"].'</div><div>Prénom : '.$row["prenom"].'</div><div>Sexe : '.$row["sexe"].'</div>'.'<div>Ville : '.$row["ville"].'</div><div>Travail : '.$row["job"].'</div><div>Date de naissance : '.$row["ddn"].'</div>';
      }
    }
  }

  deconnecterBDD($db);
?>
</div>
</body>
</html>

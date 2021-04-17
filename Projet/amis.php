<?php
  session_start();
  if ($_SESSION==[]) {
    header('Location : connectinscrip.php');
  } else {
  echo '
<!DOCTYPE html>
<html>
<head lang="fr">
    <meta charset="UTF-8">
    <title>Site</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="traitement.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href=\'style1.css\' rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Eisti\'book</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="filactu.php">Accueil</a></li>
                <li><a href="messagerie.php"><span class="glyphicon glyphicon-envelope"></span></a></li>
                <li><a href="profil.php">Profil</a></li>
                <li><a href="notif.php">Notification</a></li>
                <li><a href="amis.php">Amis</a></li>
                <li><a href=\'connectinscrip.php\'>Déconnexion</a></li>
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
    <div class="content">
  <div class="recherche">
    <form class="example" action="amis.php" style="margin:auto;max-width:300px" method="post">
      <input type="text" placeholder="Rechercher un amis" name="search2">
      <button type="submit" name="Recherche"><i class="fa fa-search"></i></button>
    </form>
  </div>
  <div id="confirmation"></div>';

  require("util.php");

  error_reporting(-1);
  ini_set('display_errors', 'On');
  if (isset($_POST['Recherche'])) {
    echo(trySearch($_POST));
  }

  echo '<div id=\'lstamis\'>';

    $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
    $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);

      $mail=$_SESSION['email'];

      $query = "SELECT * FROM Public WHERE idPublic=(SELECT idAmi2 FROM Amis WHERE idAmi1=(SELECT idPublic FROM Public WHERE mail='".$mail."'))";
      $query1 = "SELECT * FROM Public WHERE idPublic=(SELECT idAmi1 FROM Amis WHERE idAmi2=(SELECT idPublic FROM Public WHERE mail='".$mail."'))";
      $result=mysqli_query($db,$query) or die('Pb req : '.$query);
      $result1=mysqli_query($db,$query1) or die('Request error: '.$query1);

      $tab = [];
      $i =0;
      $j=0;
      $tab1=[];
      $tabf1=[];
      $tabf2=[];
      $a=0;
      $b=0;

      $nm='';
      $prnm='';

      if (mysqli_num_rows($result) >0) {
        while($row = mysqli_fetch_assoc($result)) {
          $tab[$i]=array('nom' => $row['nom'], 'prenom' => $row['prenom'], 'sexe' => $row['sexe']);
          $i=$i+1;
        }
      }
      if (mysqli_num_rows($result1) >0) {
        while($row1 = mysqli_fetch_assoc($result1)) {
          $tab1[$j]=array('nom' => $row1['nom'], 'prenom' => $row1['prenom'], 'sexe' => $row1['sexe']);
          $j=$j+1;
        }
      }
      $k=0;
      foreach ($tab as &$value) {
        $tabf1[0][$a]=$tab[$k]['nom'];
        $tabf1[1][$a]=$tab[$k]['prenom'];
        $tabf1[2][$a]=$tab[$k]['sexe'];
        $k=$k+1;
        $a=$a+1;
      }
      $l=0;
      foreach ($tab1 as &$value) {
        $tabf2[0][$b]=$tab1[$l]['nom'];
        $tabf2[1][$b]=$tab1[$l]['prenom'];
        $tabf2[2][$b]=$tab1[$l]['sexe'];
        $l=$l+1;
        $b=$b+1;
      }
      //Deux tableaux classiques non triés



      $k=0;
      $l=0;
      $m=0;
      $tabfi=[];

      //Tri du tableau
      if (($tabf1==[]) && ($tabf2==[])) {
        echo "Vous n'avez pas encore d'amis.";
      } elseif ($tabf1==[]) {
        $tabfi[0]=$tabf1[0];
        $tabfi[1]=$tabf1[1];
        $tabfi[2]=$tabf1[2];
      } elseif ($tabf2==[]) {
        $tabfi[0]=$tabf2[0];
        $tabfi[1]=$tabf2[1];
        $tabfi[2]=$tabf2[2];
      } else {
      while ($k<sizeof($tabf1[0]) && $l<sizeof($tabf2[0])) {
        if ($tabf1[0][$k] <= $tabf2[0][$l]) {
          $tabfi[0][$m]=$tabf1[0][$k];
          $tabfi[1][$m]=$tabf1[1][$k];
          $tabfi[2][$m]=$tabf1[2][$k];
          $k=$k+1;

        } else {
          $tabfi[0][$m]=$tabf2[0][$l];
          $tabfi[1][$m]=$tabf2[1][$l];
          $tabfi[2][$m]=$tabf2[2][$l];
          $l=$l+1;
        }
        $m=$m+1;
      }
      if ($k<sizeof($tabf1[0])) {
        for ($i=$k;$i<sizeof($tabf1[0]);$i++) {
          $tabfi[0][$m]=$tabf1[0][$i];
          $tabfi[1][$m]=$tabf1[1][$i];
          $tabfi[2][$m]=$tabf1[2][$i];
          $m=$m+1;
        }
      }
      if ($l<sizeof($tabf2[0])) {
        for ($i=$l;$i<=sizeof($tabf2[0]);$i++) {
          $tabfi[0][$m]=$tabf2[0][$i];
          $tabfi[1][$m]=$tabf2[1][$i];
          $tabfi[2][$m]=$tabf2[2][$i];
          $m=$m+1;
        }
      }
      //Affichage du tableau
      for ($o=0; $o<sizeof($tabfi[0]) ; $o++) {
        $nm=$tabfi[0][$o];
        $prnm=$tabfi[1][$o];
        echo '<div class="amis">';
        echo '<div class="imgamis">';
        $querya="SELECT * FROM Image WHERE idImage=(SELECT Idpdp FROM Public WHERE nom='".$nm."' AND prenom='".$prnm."')";
        $resulta=mysqli_query($db,$querya) or die('Request error: '.$querya);
        if (mysqli_num_rows($resulta) >0) {
          while($rowa=mysqli_fetch_assoc($resulta)) {
        		echo '<img src="images/'.$rowa["nom"].'.'.$rowa["type"].'"/>';
      		}
      	}
        echo '</div>';
        echo '<div class="infamis">';
        echo '<div> <p onclick="autreprof(\''.$nm.'\',\''.$prnm.'\')">'.$nm.' '.$prnm.'</p></div>';
        echo '<div class="boutons">';
        echo '<div class = "b"id=\'sese\'><button style="font-size:24px" onclick="document.location.href=\'messagerie.php\'"><i class="fa fa-comment-o"></i></button></div>';
        echo '<div class = "b"><button style="font-size:24px" onclick="motif(\''.$tabfi[0][$o].'\',\''.$tabfi[1][$o].'\',\''.$o.'\')"><i class="fa fa-exclamation-triangle"></i></button></div>';
        echo '<div class = "b"><button style="font-size:24px" onclick="bloquer(\''.$tabfi[0][$o].'\',\''.$tabfi[1][$o].'\',\''.$o.'\')"><i class="fa fa-lock"></i></button></div>';
        echo '<div class = "b"><button style="font-size:24px" onclick="supprimer(\''.$tabfi[0][$o].'\',\''.$tabfi[1][$o].'\',\''.$o.'\')"><i class="fa fa-trash-o"></i></button></div>';
        echo '</div>';
        echo '</div>';
        echo '</div><div id="supplementaire'.$o.'"></div>';
        echo '<div id="aaa"></div>';
      }
    }
    deconnecterBDD($db);

  echo '</div></body></html>';
}
?>

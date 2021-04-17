<?php
  session_start();

//Page qui traite la suppression d'un ami. Appelée dans le fichier javascript traitement.js

  require("core.php");

  $serveur="localhost";
  $identifiant="root";
  $mdp="";
  $bdd="projet";

  $nom=$_POST['nom'];
  $prenom=$_POST['prenom'];
  $id=$_SESSION['id'];
  $idautre="";

  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);

  $querya="SELECT * FROM Public WHERE nom='".$nom."' AND prenom='".$prenom."'";
  $resulta=mysqli_query($db,$querya) or die('Request error: '.$querya);
  $rowa=mysqli_fetch_assoc($resulta);
  $idautre=$rowa["idPublic"];

  $query = "SELECT * FROM Amis WHERE idAmi2='".$id."' AND  idAmi1='".$idautre."'";
  $query1 = "SELECT * FROM Amis WHERE idAmi1='".$id."' AND  idAmi2='".$idautre."'";
  $result=mysqli_query($db,$query) or die('Pb req : '.$query);
  $row=mysqli_fetch_assoc($result);
  $result1=mysqli_query($db,$query1) or die('Request error: '.$query1);
  $row1=mysqli_fetch_assoc($result1);

  if ($row==[]) {
    if ($row1!=[]) {
      $query3 = "DELETE FROM Amis WHERE idAmi1='".$id."' AND  idAmi2='".$idautre."'";
      $result3=mysqli_query($db,$query3) or die('Pb req : '.$query3);
      echo 'L\'utilisateur a été supprimé de vos amis. ';
    }
  } else {
    $query3 = "DELETE FROM Amis WHERE idAmi2='".$id."' AND  idAmi1='".$idautre."'";
    $result3=mysqli_query($db,$query3) or die('Pb req : '.$query3);
    echo 'L\'utilisateur a été supprimé de vos amis. ';
  }
?>

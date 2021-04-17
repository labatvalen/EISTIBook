<?php
  session_start();

//Page qui traite le signalement d'une personne par une autre. Appelée dans le fichier javascript traitement.js

  require("core.php");

  $serveur="localhost";
  $identifiant="root";
  $mdp="";
  $bdd="projet";

  $id=$_SESSION['id'];
  $id1='';
  $val='échec';

  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);

  $query = "SELECT * FROM Public WHERE nom=\"".$_POST['nom']."\" AND prenom=\"".$_POST['prenom']."\"";
  $result=mysqli_query($db,$query) or die('Request error: '.$query);
  if (mysqli_num_rows($result) >0) {
    $row=mysqli_fetch_assoc($result);
    $id1=$row['idPublic'];
  }
  $query8="SELECT * FROM Signalement WHERE idSignaleur='".$id."' AND idSignale='".$id1."'";
  $result8=mysqli_query($db,$query8) or die('Request error: '.$query8);
  if (mysqli_num_rows($result8) >0) {
    $val="Vous avez déjà signalé cet utilisateur aux administrateurs. Le cas sera étudié dans les plus brefs délais.";
  } else {
    $moti=$_POST['moti'];
    $date=date('Y').'-'.date('m').'-'.date('d').' '.date('H').':'.date('i').':'.date('s');
    $query1 = "INSERT INTO Signalement (idSignaleur,idSignale,dt,motif) VALUES (\"".$id."\",\"".$id1."\",\"".$date."\",\"".$moti."\")";
    $result1=mysqli_query($db,$query1) or die('Request error: '.$query1);
    $val='Cette personne a bien été signalée à nos administrateurs. Note : Pour améliorer votre expérience sur l\'application, vous pouvez bloquer ou supprimer cet utilisateur.';
  }
  deconnecterBDD($db);
  echo $val;
?>

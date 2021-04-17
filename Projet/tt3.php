<?php
  session_start();

//Page qui traite la modification de son propre profil. Appelée dans le fichier javascript traitement.js

  require("core.php");

  $serveur="localhost";
  $identifiant="root";
  $mdp="";
  $bdd="projet";

  $sexeact="";
  $nom=$_POST['nom'];
  $prenom=$_POST['prenom'];
  $sexe=$_POST['sexe'];
  $ville=$_POST['ville'];
  $travail=$_POST['travail'];
  $ddn=$_POST['ddn'];
  $email=$_POST['email'];
  $amdp=$_POST['amdp'];
  $nmdp=$_POST['nmdp'];
  $cmdp=$_POST['cmdp'];
  $id=$_SESSION['id'];
  $nbrmodif=0;

  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);

  if ($nom!="") {
    $query1="UPDATE Public SET nom='".$nom."' WHERE idPublic='".$id."'";
    $result1=mysqli_query($db,$query1) or die('Request error: '.$query1);
    $nbrmodif=$nbrmodif+1;
  }
  if ($prenom!="") {
    $query2="UPDATE Public SET prenom='".$prenom."' WHERE idPublic='".$id."'";
    $result2=mysqli_query($db,$query1) or die('Request error: '.$query1);
    $nbrmodif=$nbrmodif+1;
  }
  if ($sexe!="") {
    $query99 = "SELECT * FROM Public WHERE idPublic ='".$id."'";
    $res99 = mysqli_query($db, $query99) or die('Request error : '.$query99);
    $row99=mysqli_fetch_assoc($res99);
    $sexeact=$row99['sexe'];
    if ($sexeact!=$sexe) {
      $query3="UPDATE Public SET sexe='".$sexe."' WHERE idPublic='".$id."'";
      $result3=mysqli_query($db,$query3) or die('Request error: '.$query3);
      $nbrmodif=$nbrmodif+1;
    }
  }
  if ($ville!="") {
    $query4="UPDATE Public SET ville='".$ville."' WHERE idPublic='".$id."'";
    $result4=mysqli_query($db,$query4) or die('Request error: '.$query4);
    $nbrmodif=$nbrmodif+1;
  }
  if ($travail!="") {
    $query5="UPDATE Public SET job='".$travail."' WHERE idPublic='".$id."'";
    $result5=mysqli_query($db,$query5) or die('Request error: '.$query5);
    $nbrmodif=$nbrmodif+1;
  }

  $i=0;
  $j=8;
  $bon=true;
  $bon2=true;
  $bon3=true;
  $bon4=true;
  $bon5=true;
  $bonfin1=true;
  $bonfin2=true;
  $bissextile=false;
  $anJ=date('Y');
  $moisJ=date('m');
  $jourJ=date('d');

  if ($ddn!="") {
    if (strlen($ddn)!=10) {
      echo 'Entrez un modèle de date cohérent. Exemple : aaaa-mm-jj';
    } else {
      while ($i<4 and $bon) {
        if ($ddn[$i]=='0' or $ddn[$i]=='1' or $ddn[$i]=='2' or $ddn[$i]=='3' or $ddn[$i]=='4' or $ddn[$i]=='5' or $ddn[$i]=='6' or $ddn[$i]=='7' or $ddn[$i]=="8" or $ddn[$i]=='9') {
          $i=$i+1;
        } else {
          $bon=false;
        }
      }
      if ($ddn[4]!='-' or $ddn[7]!='-') {
        $bon2=false;
      }
      while ($j<10 and $bon3) {
        if ($ddn[$j]=='0' or $ddn[$j]=='1' or $ddn[$j]=='2' or $ddn[$j]=='3' or $ddn[$j]=='4' or $ddn[$j]=='5' or $ddn[$j]=='6' or $ddn[$j]=='7' or $ddn[$j]=="8" or $ddn[$j]=='9') {
          $j=$j+1;
        } else {
          $bon3=false;
        }
      }
      if ($ddn[5]=='0' or $ddn[5]=='1' or $ddn[5]=='2' or $ddn[5]=='3' or $ddn[5]=='4' or $ddn[5]=='5' or $ddn[5]=='6' or $ddn[5]=='7' or $ddn[5]=="8" or $ddn[5]=='9') {
        $bon4=true;
      } else {
        $bon4=false;
      }
      if ($ddn[6]=='0' or $ddn[6]=='1' or $ddn[6]=='2' or $ddn[6]=='3' or $ddn[6]=='4' or $ddn[6]=='5' or $ddn[6]=='6' or $ddn[6]=='7' or $ddn[6]=="8" or $ddn[6]=='9') {
        $bon5=true;
      } else {
        $bon5=false;
      }
      if ($bon==true and $bon2==true and $bon3==true and $bon4==true and $bon5==true) {
        $jour=$ddn[8].$ddn[9];
        $mois=$ddn[5].$ddn[6];
        $an=$ddn[0].$ddn[1].$ddn[2].$ddn[3];
        //vérification que la date soit inférieure à celle du jour
        if ($an>$anJ) {
          $bonfin1=false;
        } elseif ($an==$anJ and $mois>$moisJ) {
          $bonfin1=false;
        } elseif ($an==$anJ and $mois==$moisJ and $jour>$jourJ) {
          $bonfin1=false;
        }
        //vérification que la date entrée soit correcte
        if (($an%400==0) or ($an%100!=0 and $an%4==0)) {
          $bissextile=true;
        }
        if ($mois>'12') {
          $bonfin2=false;
        } elseif ($mois=='01' or $mois=='03' or $mois=='05' or $mois=='07' or $mois=='08' or $mois=='10' or $mois=='12') {
          if ($jour>31) {
            $bonfin2=false;
          }
        } elseif ($mois=='02') {
            if ($bissextile) {
              if ($jour>29) {
                $bonfin2=false;
              }
            } else {
              if ($jour>28) {
                $bonfin2=false;
              }
            }
          } else {
            if ($jour>30) {
              $bonfin2=false;
            }
          }
          if ($bonfin1 and $bonfin2) {
              $query6="UPDATE Public SET ddn='".$ddn."' WHERE idPublic='".$id."'";
              $result6=mysqli_query($db,$query6) or die('Request error: '.$query6);
              $nbrmodif=$nbrmodif+1;
          } else {
            echo 'Entrez un modèle de date cohérent. Exemple : 13/07/1999';
          }

        } else {
          echo 'Entrez un modèle de date cohérent. Exemple : 13/07/1999';
        }
      }
  }
  if ($email!="") {
    $query7 = "SELECT * FROM Public WHERE mail=\"".$email."\"";
  	$result7=mysqli_query($db,$query7) or die('Request error: '.$query7);
  	if (mysqli_num_rows($result7)==0) {
      $query8="UPDATE Public SET mail='".$email."' WHERE idPublic='".$id."'";
      $result8=mysqli_query($db,$query8) or die('Request error: '.$query8);
      $query9="UPDATE Privee SET email='".$email."' WHERE idPrivee='".$id."'";
      $result9=mysqli_query($db,$query9) or die('Request error: '.$query9);
      $_SESSION['email']=$email;
      $nbrmodif=$nbrmodif+1;
    } else {
      echo 'Cette adresse mail est déjà utilisée. Choisissez-en une autre.';
    }
  }
  if ($amdp!="") {
    $query10 = "SELECT * FROM Privee WHERE mdp=\"".$amdp."\"";
  	$result10=mysqli_query($db,$query10) or die('Request error: '.$query10);
  	if (mysqli_num_rows($result10)>0) {
      if ($nmdp!="") {
        if ($nmdp==$cmdp) {
          $query11="UPDATE Privee SET mdp='".$nmdp."' WHERE idPrivee='".$id."'";
          $result11=mysqli_query($db,$query11) or die('Request error: '.$query11);
          $nbrmodif=$nbrmodif+1;
        } else {
          echo 'Les deux nouveaux mots de passe entrés sont différents.';
        }
      } else {
        echo 'Veuillez entrer un nouveau mot de passe.';
      }
    } else {
      echo 'Votre ancien mot de passe est erroné.';
    }
  } else {
    if ($nmdp!="" or $cmdp!="") {
      echo "Entrez votre ancien mot de passe pour changer votre mot de passe.";
    }
  }
  echo '<br>';
  if ($nbrmodif<2) {
    echo $nbrmodif.' modification effectuée.';
  } else {
    echo $nbrmodif.' modifications effectuées.';
  }
  deconnecterBDD($db);
?>

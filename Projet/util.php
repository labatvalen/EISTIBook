<?php

//fichier contenant les fonctions php utilisées

//on utilise les fonction de connection et déconnection de fichier core.php
require("core.php");


//"identifiants" de connection à la BDD
$serveur="localhost";
$identifiant="root";
$mdp="";
$bdd="projet";


//fonction de connection
function tryLogin($formdata) {
  //on se connecte à la BDD
  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);

  $email = $formdata['email'];
  $motDePasse = $formdata['password'];

  //on cherche si les identifiants sont dans la BDD
  $query = "SELECT * FROM Privee WHERE email='".$email."' AND mdp='".$motDePasse."'";
  $result=mysqli_query($db,$query) or die('Request error: '.$query);
  $i =0;
  $tab=[];
  $pastrouve=true;
  if (mysqli_num_rows($result) >0) {
    $row=mysqli_fetch_assoc($result);
    $_SESSION['email']=$email;               //variable de session de l'email de l'utilisateur
    $_SESSION['id']=$row['idPrivee'];       //variable de session de l'id de l'utilisateur
  }
  deconnecterBDD($db);
  if (isset($row)) {
    return $row;
  }
}


//fonction d'inscription
function tryInscription($formdata) {

  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);

    //on récupère les données du formulaire
    $prenom = $formdata['prenom'];
    $nom = $formdata['nom'];
    $bday = $formdata['bday'];
    $gender = $formdata['gender'];
    $tel = $formdata['tel'];
    $mail = $formdata['mail'];
    $mdp = $formdata['mdp'];
    $mdpc = $formdata['mdpc'];
    $t=strlen($mail);
    $id='';
    $val='';
    $val1='';
    $m=0;
    $msformat=true;
    $pasat=true;

    $ans=0;
    //verification que toutes les informations essentielles soient entrées
    if (($prenom<>'') AND ($nom<>'') AND ($bday<>'') AND ($gender<>'') AND ($tel<>'') AND ($mail<>'') AND ($mdp<>'') AND ($mdpc<>'')) {

      //verification que le mot de passe soit le même que sa confirmation
      if ($mdp==$mdpc) {

        //verification que l'adresse ne soit pas déjà utilisé
        $queryz  = "SELECT * FROM Public WHERE mail='".$mail."'";
        $resultz = mysqli_query($db,$queryz) or die('Request error: '.$queryz);
        if (mysqli_num_rows($resultz)==0) {

          $anJ=date('Y');
          $moisJ=date('m');
          $jourJ=date('d');
          $jour=$bday[8].$bday[9];
          $mois=$bday[5].$bday[6];
          $an=$bday[0].$bday[1].$bday[2].$bday[3];
          //vérification que la date soit inférieure à celle du jour
          if ($an>$anJ) {
            $ans=-3;
          } elseif ($an==$anJ and $mois>$moisJ) {
            $ans=-3;
          } elseif ($an==$anJ and $mois==$moisJ and $jour>$jourJ) {
            $ans=-3;
          } else {
            //vérification que le format de l'adresse mail soit correct
            while ($m<$t and $msformat) {
              while ($pasat and $m<$t) {
                if ($mail[$m]!='@') {
                  $m=$m+1;
                } else {
                  $pasat=false;
                }
              }
              if ($mail[$m]=='.' and !$pasat) {
                $msformat=false;
              } else {
                $m=$m+1;
              }
            }
            if ($msformat) {
              $ans=-10;
            } else {

              //si photo importée
              if (isset($_SESSION['idpdp'])) {
                $val=$_SESSION['idpdp'];

                //insere les valeurs dans la BDD
                $query = "INSERT INTO Public (nom,prenom,mail,sexe,Idpdp,ddn) VALUES ('".$nom."','".$prenom."','".$mail."','".$gender."','".$val."','".$bday."')";
                $result=mysqli_query($db,$query) or die('Pb req : '.$query);
                $query1 = "INSERT INTO Privee (mdp,email) VALUES ('".$mdp."','".$mail."')";
                $result1=mysqli_query($db,$query1) or die('Request error: '.$query1);
                $query2 = "SELECT * FROM Privee WHERE email='".$mail."' AND mdp='".$mdp."'";
                $result2=mysqli_query($db,$query2) or die('Request error: '.$query2);
                if (mysqli_num_rows($result2) >0) {
                  $row=mysqli_fetch_assoc($result2);
                  $id=$row['idPrivee'];
                }
                $query3 = "INSERT INTO Utilisateur (idUtilisateur,idPublic,idPrivee) VALUES ('".$id."','".$id."','".$id."')";
                $result3=mysqli_query($db,$query3) or die('Pb req : '.$query3);

                //si photo de base et homme ou femme
              } elseif ($gender!='autre') {

              //si image déjà dans bdd on fait rien, sinon on l'ajoute
              $queryn1  = "SELECT * FROM Image WHERE nom='".$gender."'";
              $resultn1 = mysqli_query($db,$queryn1) or die('Request error: '.$queryn1);
              if (mysqli_num_rows($resultn1)==0) {
                $querya = "INSERT INTO Image (taille,nom,type) VALUES ('500x500','".$gender."','jpg')";
                $resulta=mysqli_query($db,$querya) or die('Pb req : '.$querya);
              }

              //trouve l'id de l'image choisie
              $queryn = "SELECT * FROM Image WHERE nom='".$gender."'";
              $resultn=mysqli_query($db,$queryn) or die('Request error: '.$queryn);
              $row=mysqli_fetch_assoc($resultn);
              $val1=$row['idImage'];

              //insere les valeurs dans la BDD
              $query = "INSERT INTO Public (nom,prenom,mail,sexe,Idpdp,ddn) VALUES ('".$nom."','".$prenom."','".$mail."','".$gender."','".$val1."','".$bday."')";
              $result=mysqli_query($db,$query) or die('Pb req : '.$query);

              $query1 = "INSERT INTO Privee (mdp,email) VALUES ('".$mdp."','".$mail."')";
              $result1=mysqli_query($db,$query1) or die('Request error: '.$query1);
              $query2 = "SELECT * FROM Privee WHERE email='".$mail."' AND mdp='".$mdp."'";
              $result2=mysqli_query($db,$query2) or die('Request error: '.$query2);
              if (mysqli_num_rows($result2) >0) {
                $row=mysqli_fetch_assoc($result2);
                $id=$row['idPrivee'];
              }
              $query3 = "INSERT INTO Utilisateur (idUtilisateur,idPublic,idPrivee) VALUES ('".$id."','".$id."','".$id."')";
              $result3=mysqli_query($db,$query3) or die('Pb req : '.$query3);

              //si sexe autre
            } elseif ($gender=='autre') {

              //si image déjà dans bdd on fait rien, sinon on l'ajoute
              $queryn1  = "SELECT * FROM Image WHERE nom='".$gender."'";
              $resultn1 = mysqli_query($db,$queryn1) or die('Request error: '.$queryn1);
              if (mysqli_num_rows($resultn1)==0) {
                $querya = "INSERT INTO Image (taille,nom,type) VALUES ('500x500','".$gender."','jpeg')";
                $resulta=mysqli_query($db,$querya) or die('Pb req : '.$querya);
              }

              //trouve l'id de l'image choisie
              $queryn = "SELECT * FROM Image WHERE nom='".$gender."'";
              $resultn=mysqli_query($db,$queryn) or die('Request error: '.$queryn);
              $row=mysqli_fetch_assoc($resultn);
              $val1=$row['idImage'];

              //insere les valeurs dans la BDD
              $query = "INSERT INTO Public (nom,prenom,mail,sexe,Idpdp,ddn) VALUES ('".$nom."','".$prenom."','".$mail."','".$gender."','".$val1."','".$bday."')";
              $result=mysqli_query($db,$query) or die('Pb req : '.$query);

              $query1 = "INSERT INTO Privee (mdp,email) VALUES ('".$mdp."','".$mail."')";
              $result1=mysqli_query($db,$query1) or die('Request error: '.$query1);
              $query2 = "SELECT * FROM Privee WHERE email='".$mail."' AND mdp='".$mdp."'";
              $result2=mysqli_query($db,$query2) or die('Request error: '.$query2);
              if (mysqli_num_rows($result2) >0) {
                $row=mysqli_fetch_assoc($result2);
                $id=$row['idPrivee'];
              }

              $query3 = "INSERT INTO Utilisateur (idUtilisateur,idPublic,idPrivee) VALUES ('".$id."','".$id."','".$id."')";
              $result3=mysqli_query($db,$query3) or die('Pb req : '.$query3);

          }
          unset($_SESSION['idpdp']);
          unset($idpdp);
          $ans=1;
        }
      }
      } else {
        $ans=-2;
      }
      } else {
        $ans=-1;
      }
    } else {
      $ans =0;
    }

    deconnecterBDD($db);
    return $ans;
}

//fonction de recherche parmi les amis
function trySearch($formdata) {

  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);

  $champ = $formdata['search2'];

  $ans=0;
    //verifaction que les carctères cherchés soient semblables à un des amis (nom ou prenom)
    $query = "SELECT * FROM Public WHERE nom LIKE '%".$champ."%'";
    $result=mysqli_query($db,$query) or die('Pb req : '.$query);

    $query1 = "SELECT * FROM Public WHERE prenom LIKE '%".$champ."%'";
    $result1=mysqli_query($db,$query1) or die('Pb req : '.$query1);
    echo '<br><br><br><div class="amis">';
    echo '<div class="imgamis">';

    $o=0;
    if (mysqli_num_rows($result) >0) {
        while($rowa=mysqli_fetch_assoc($result)) {

          $nm=$rowa['nom'];
          $prnm=$rowa['prenom'];
          $queryb="SELECT * FROM Image WHERE idImage=(SELECT Idpdp FROM Public WHERE nom='".$nm."' AND prenom='".$prnm."')";
          $resultb=mysqli_query($db,$queryb) or die('Request error: '.$queryb);
          if (mysqli_num_rows($resultb) >0) {
          $rowb=mysqli_fetch_assoc($resultb);
          echo '<img src="images/'.$rowb["nom"].'.'.$rowb["type"].'"/>';
        }
      echo '</div>';
      echo '<div class="infamis">';
      echo '<div> <p onclick="autreprof(\''.$rowa["nom"].'\',\''.$rowa['prenom'].'\')">'.$rowa["nom"].' '.$rowa['prenom'].'</p></div>';
      echo '<div class="boutons">';
      echo '<div class = "b"id=\'sese\'><button style="font-size:24px" onclick="document.location.href=\'messages.php\'"><i class="fa fa-comment-o"></i></button></div>';
      echo '<div class = "b"><button style="font-size:24px" onclick="motif(\''.$rowa["nom"].'\',\''.$rowa['prenom'].'\',\''.$o.'\')"><i class="fa fa-exclamation-triangle"></i></button></div>';
      echo '<div class = "b"><button style="font-size:24px" onclick="bloquer(\''.$rowa["nom"].'\',\''.$rowa['prenom'].'\',\''.$o.'\')"><i class="fa fa-lock"></i></button></div>';
      echo '<div class = "b"><button style="font-size:24px" onclick="supprimer(\''.$rowa["nom"].'\',\''.$rowa['prenom'].'\',\''.$o.'\')"><i class="fa fa-trash-o"></i></button></div>';
      echo '</div>';
      echo '</div>';
      echo '</div><div id="supplementaire'.$o.'"></div>';
      echo '<div id="aaa"></div><br><br><br>';
$o=$o+1;
}
  } elseif (mysqli_num_rows($result1) >0) {
    while($rowa=mysqli_fetch_assoc($result1)) {

      $nm=$rowa['nom'];
      $prnm=$rowa['prenom'];
      $queryb="SELECT * FROM Image WHERE idImage=(SELECT Idpdp FROM Public WHERE nom='".$nm."' AND prenom='".$prnm."')";
      $resultb=mysqli_query($db,$queryb) or die('Request error: '.$queryb);
      if (mysqli_num_rows($resultb) >0) {
      $rowb=mysqli_fetch_assoc($resultb);
      echo '<img src="images/'.$rowb["nom"].'.'.$rowb["type"].'"/>';
    }
  echo '</div>';
  echo '<div class="infamis">';
  echo '<div> <p onclick="autreprof(\''.$rowa["nom"].'\',\''.$rowa['prenom'].'\')">'.$rowa["nom"].' '.$rowa['prenom'].'</p></div>';
  echo '<div class="boutons">';
  echo '<div class = "b"id=\'sese\'><button style="font-size:24px" onclick="document.location.href=\'messages.php\'"><i class="fa fa-comment-o"></i></button></div>';
  echo '<div class = "b"><button style="font-size:24px" onclick="motif(\''.$rowa["nom"].'\',\''.$rowa['prenom'].'\',\''.$o.'\')"><i class="fa fa-exclamation-triangle"></i></button></div>';
  echo '<div class = "b"><button style="font-size:24px" onclick="bloquer(\''.$rowa["nom"].'\',\''.$rowa['prenom'].'\',\''.$o.'\')"><i class="fa fa-lock"></i></button></div>';
  echo '<div class = "b"><button style="font-size:24px" onclick="supprimer(\''.$rowa["nom"].'\',\''.$rowa['prenom'].'\',\''.$o.'\')"><i class="fa fa-trash-o"></i></button></div>';
  echo '</div>';
  echo '</div>';
  echo '</div><div id="supplementaire'.$o.'"></div>';
  echo '<div id="aaa"></div><br><br><br>';
$o=$o+1;
}
  }else {
    $ans="ne fait pas parti de vos amis";
  }

    deconnecterBDD($db);
    return $ans;
}



function convertUser($id){
    $name = [];
    $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
    $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);
    $query = "SELECT * From Public WHERE idPublic = $id";
    $res = mysqli_query($db, $query) or die('Request error : '.$query);

    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $name['nom'] = $row['nom'];
            $name['prenom'] = $row['prenom'];
        }
        }else {
            echo "error_1";
        }
    mysqli_close($db);
    deconnecterBDD($db);
    return $name;
}

function getImg($idImg){
    if ($idImg <> 0){
        $link = "notfound.png";
        $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
        $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);

        $query = "SELECT * FROM Image WHERE $idImg = idImage";
        $res = mysqli_query($db, $query) or die('Request error : '.$query);
        if (mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {
                $pic = $row['nom'].".".$row['type'];
                $size = explode('x',$row['taille']);
                $link = '<img src="images/'.$pic.'" width="'.$size[0].'" height="'.$size[1].'"/>'; /** changer les tailles */
            }
            }else {
                echo "No results";
            }
        mysqli_close($db);
        deconnecterBDD($db);
        return $link;
    }
}

function getLike($idU,$idP){
  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);
    $query = "SELECT * FROM React WHERE (idUtilisateur=$idU) AND (idPublication=$idP)";
    $res = mysqli_query($db, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        $bool = false;
    }else {
        $bool = true;
    }
    deconnecterBDD($db);
    return($bool);
}

function getnbLike ($idP){
  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);
    $query = "SELECT * FROM React WHERE (idPublication=$idP)";
    $res = mysqli_query($db, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        $nb = mysqli_num_rows($res);
    }else {
        $nb = 0;
    }
    deconnecterBDD($db);
    return($nb);
}

function getPublications($utilisateur){
    $Publications = [];
    $like = "Nan";
    $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
    $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);
    $query = "SELECT * From Publication WHERE (((idUtilisateur,$utilisateur) IN (SELECT * From Amis)) OR (($utilisateur,idUtilisateur) IN (SELECT * From Amis)) OR (idUtilisateur=$utilisateur)) ORDER BY dt DESC";
    $res = mysqli_query($db, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $nblike = getnbLike($row['idPublication']);
            if (getLike($utilisateur,$row['idPublication'])){
                $like=" <button class='btnLike' id=P".$row['idPublication']." onclick='like(".$row['idPublication'].",".$utilisateur.")'>♡$nblike</button>";
            }else{
                $like= " <button class='btndisLike' id=P".$row['idPublication']." onclick='dislike(".$row['idPublication'].",".$utilisateur.")'>♥$nblike</button>";
            }
            $Publications[] = array('idPublication' => $row['idPublication'],'Date de publication' => $row['dt'],'Nom' => convertUser($row['idUtilisateur'])['nom'],'Prénom' => convertUser($row['idUtilisateur'])['prenom'],'Contenu' => $row['content'],'J\'aime' => $like, 'Image' => getImg($row['image']) , 'Signaler' => "<button type='button' class='btnSignal' onclick='signalP(".$row['idPublication'].",$utilisateur,".$row['idUtilisateur'].")'>signaler ☛</button>");
        }
    }else {
        echo "No results";
    }
    deconnecterBDD($db);
    initWall($Publications);
    return $Publications;
}

function signalerP($idPublication,$idSignaleur,$idSignale,$motif){
  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);
    $query = "INSERT INTO Signalement (dt,idPublication,idSignaleur,idSignale,motif) VALUES (NOW(),$idPublication,$idSignaleur,$idSignale,'$motif')";
    $res = mysqli_query($db, $query) or die('Request error : '.$query);
    deconnecterBDD($db);
}

function like($idUtilisateur,$idPublication){
  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);
    $query = "INSERT INTO React (idUtilisateur,idPublication) VALUES ($idUtilisateur,$idPublication)";
    $res = mysqli_query($db, $query) or die('Request error : '.$query);
    deconnecterBDD($db);
    $n = getnbLike($idPublication);
    echo(" <button class='btndisLike' id=P".$idPublication." onclick='dislike($idPublication,$idUtilisateur)'>♥$n</button>");
}

function dislike($idUtilisateur,$idPublication){
  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);
    $query = "DELETE from React WHERE (idUtilisateur,idPublication)=($idUtilisateur,$idPublication)";
    $res = mysqli_query($db, $query) or die('Request error : '.$query);
    deconnecterBDD($db);
    $n = getnbLike($idPublication);
    echo (" <button class='btnLike' id=P".$idPublication." onclick='like($idPublication,$idUtilisateur)'>♡$n</button>");
}

function rechercheU($name){
    $el = explode(" ", $name);
    $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
    $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);
    $query = "SELECT * FROM Public WHERE nom LIKE '%$el[0]%'";
    $res = mysqli_query($db, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            echo ($row['nom']." ".$row['prenom']); //PROBLEME!
        }
    }else {
        echo "No results";
    }
    deconnecterBDD($db);
}

function getUpload($img){
    $Signalement[] = [];
    $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
    $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);
    $query = "SELECT idImage From Image WHERE (nom = '$img')";
    $res = mysqli_query($db, $query) or die('Request error : '.$query);
    deconnecterBDD($db);
    return($res);
}

function initImg($taille,$nom,$extension){
  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);
    $query = "INSERT INTO Image (taille,nom,type) VALUES ('$taille','$nom','$extension')";
    $res = mysqli_query($db, $query) or die('Request error : '.$query);
    if ($res > 0){
        return(getUpload($nom));
    }
    deconnecterBDD($db);

}

function initImg1($taille,$nom,$extension){
  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);
    $query = "INSERT INTO Image (taille,nom,type) VALUES ('$taille','$nom','$extension')";
    $res = mysqli_query($db, $query) or die('Request error : '.$query);

    $_SESSION['idpdp']=0;
    $query1 = "SELECT * FROM Image WHERE taille ='".$taille."' AND nom='".$nom."' AND type='".$extension."'";
    $res1 = mysqli_query($db, $query1) or die('Request error : '.$query1);
    if (mysqli_num_rows($res1) >0) {
      $row1=mysqli_fetch_assoc($res1);
        $_SESSION['idpdp']=$row1['idImage'];
    }
    mysqli_close($db);
    deconnecterBDD($db);
}

function afficheprofil($formdata) {

  $db = connecterBDD($GLOBALS['serveur'],$GLOBALS['identifiant'],$GLOBALS['mdp']);
  $boolRes = mysqli_select_db($db,$GLOBALS['bdd']);
    $prenom = $formdata['prenom'];
    $nom = $formdata['nom'];

    $val='';

    $query = "SELECT * FROM Image WHERE nom='".$nom."' prenom='".$prenom."'";
    $result=mysqli_query($db,$query) or die('Request error: '.$query);
    if (mysqli_num_rows($result) >0) {
        $row=mysqli_fetch_assoc($result);
          $val='<div>Nom : '.$row[$nom].'</div><div>Prénom : '.$row[$prenom].'</div><div>Sexe : '.$row[$sexe].'</div><div>Ville : '.$row[$ville].'</div><div>Travail : '.$row[$job].'</div>';
        }

    deconnecterBDD($db);
    return $val;
}
?>

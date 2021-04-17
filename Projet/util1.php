<?php
require("core1.php");


function tryLogin($formdata) {

    $db = connecterBDD("localhost", "root", "");
    $boolRes = mysqli_select_db($db, 'projet');

    $email = $formdata['email'];
    $motDePasse = $formdata['password'];

    $query = "SELECT * FROM Privee WHERE email='".$email."' AND mdp='".$motDePasse."'";
    $result=mysqli_query($db,$query) or die('Request error: '.$query);
    $i =0;
    $tab=[];
    $pastrouve=true;
    if (mysqli_num_rows($result) >0) {
      $row=mysqli_fetch_assoc($result);
        echo"coucou";
    }
    deconnecterBDD($db);
    if (isset($row)) {
      return $row;
    }

    //...

    //---
}

//////////////////////////////////////MUR//////////////////////////////////////////////////

function convertUser($id){
    $name = [];
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * From Public WHERE idPublic = $id";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);

    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $name['nom'] = $row['nom'];
            $name['prenom'] = $row['prenom'];
        }
        }else {
            echo "error_1";
        }
    mysqli_close($conn);
    deconnecterBDD($db);
    return $name;
}

function getImg($idImg){
    if ($idImg <> 0){
        $link = "notfound.png";
        $db = connecterBDD("127.0.0.1", "root", "");
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "projet";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $query = "SELECT * FROM Image WHERE $idImg = idImage";
        $res = mysqli_query($conn, $query) or die('Request error : '.$query);
        if (mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {
                $pic = $row['nom'];
                $size = explode('x',$row['taille']);
                $link = '<img src="images/'.$pic.'"/>'; /** changer les tailles */
            }
            }else {
                echo "No results";
            }
        mysqli_close($conn);
        deconnecterBDD($db);
        return $link;
    }
}

function getLike($idU,$idP){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * FROM React WHERE (idUtilisateur=$idU) AND (idPublication=$idP)";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        $bool = false;
    }else {
        $bool = true;
    }
    mysqli_close($conn);
    deconnecterBDD($db);
    return($bool);
}

function getnbLike ($idP){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * FROM React WHERE (idPublication=$idP)";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        $nb = mysqli_num_rows($res);
    }else {
        $nb = 0;
    }
    mysqli_close($conn);
    deconnecterBDD($db);
    return($nb);
}

function getPublications($utilisateur){
    $Publications = [];
    $like = "Nan";
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * From Publication WHERE (((idUtilisateur,$utilisateur) IN (SELECT * From Amis)) OR (($utilisateur,idUtilisateur) IN (SELECT * From Amis)) OR (idUtilisateur=$utilisateur)) ORDER BY dt DESC";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
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
    mysqli_close($conn);
    deconnecterBDD($db);
    initWall($Publications);
    return $Publications;
}

function signalerP($idPublication,$idSignaleur,$idSignale,$motif){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "INSERT INTO Signalement (dt,idPublication,idSignaleur,idSignale,motif) VALUES (NOW(),$idPublication,$idSignaleur,$idSignale,'$motif')";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    mysqli_close($conn);
    deconnecterBDD($db);
}

function like($idUtilisateur,$idPublication){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "INSERT INTO React (idUtilisateur,idPublication) VALUES ($idUtilisateur,$idPublication)";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    mysqli_close($conn);
    deconnecterBDD($db);
    $n = getnbLike($idPublication);
    echo(" <button class='btndisLike' id=P".$idPublication." onclick='dislike($idPublication,$idUtilisateur)'>♥$n</button>");
}

function dislike($idUtilisateur,$idPublication){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "DELETE from React WHERE (idUtilisateur,idPublication)=($idUtilisateur,$idPublication)";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    mysqli_close($conn);
    deconnecterBDD($db);
    $n = getnbLike($idPublication);
    echo (" <button class='btnLike' id=P".$idPublication." onclick='like($idPublication,$idUtilisateur)'>♡$n</button>");
}

function rechercheU($name){
    $el = explode(" ", $name);
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * FROM Public WHERE nom LIKE '%$el[0]%'";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            echo ($row['nom']." ".$row['prenom']); //PROBLEME!
        }
    }else {
        echo "No results";
    }
    mysqli_close($conn);
    deconnecterBDD($db);
}

//////////////////////////////////////////PUBLIER///////////////////////////////////

function getUpload($img){
    $Signalement[] = [];
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT idImage From Image WHERE (nom = '$img')";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    mysqli_close($conn);
    deconnecterBDD($db);
    return($res);
}

function initImg($taille,$nom,$extension){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "INSERT INTO Image (taille,nom,type) VALUES ('$taille','$nom','$extension')";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    if ($res > 0){
        return(getUpload($nom));
    }
    mysqli_close($conn);
    deconnecterBDD($db);

}

function publierFA($content,$idUtilisateur,$img){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if ($img==0){
        $query = "INSERT INTO Publication (content,idUtilisateur,dt,image) VALUES ('$content',$idUtilisateur,NOW(),0)";
    }else{
        $query = "INSERT INTO Publication (content,idUtilisateur,dt,image) VALUES ('$content','$idUtilisateur',NOW(),$img)";
    }

    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    mysqli_close($conn);
    deconnecterBDD($db);
    echo '<meta http-equiv="refresh" content="0;URL=filactu.php">';
}

function getWall($utilisateur){
    $Publications = [];
    $like = "Nan";
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * From Publication WHERE (idUtilisateur=$utilisateur) ORDER BY dt DESC";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $nblike = getnbLike($row['idPublication']);
            if (getLike($utilisateur,$row['idPublication'])){
                $like=" <button class='btnLike' id=P".$row['idPublication']." onclick='like(".$row['idPublication'].",".$utilisateur.")'>♡$nblike</button>";
            }else{
                $like= " <button class='btndisLike' id=P".$row['idPublication']." onclick='dislike(".$row['idPublication'].",".$utilisateur.")'>♥$nblike</button>";
            }
            $Publications[] = array('idPublication' => $row['idPublication'],'Date de publication' => $row['dt'],'Nom' => convertUser($row['idUtilisateur'])['nom'],'Prénom' => convertUser($row['idUtilisateur'])['prenom'],'Contenu' => $row['content'],'J\'aime' => $like, 'Image' => getImg($row['image']), 'Supprimer' => "<input type='button' value='Supprimer' onclick='deleteP(".$row['idPublication'].")'>");
        }
    }else {
        echo "No results";
    }
    mysqli_close($conn);
    deconnecterBDD($db);
    initWall($Publications);
    return $Publications;
}

function deleteP($idPublication){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "DELETE from Publication WHERE (idPublication = $idPublication)";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    mysqli_close($conn);
    deconnecterBDD($db);
    echo '<meta http-equiv="refresh" content="0;URL=profil.php">';
}

function publierM($content,$idUtilisateur){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "INSERT INTO Publication (content,idUtilisateur,dt) VALUES ('$content','$idUtilisateur',NOW())";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    mysqli_close($conn);
    deconnecterBDD($db);
    echo '<meta http-equiv="refresh" content="0;URL=profil.php">';
}

function rechercher($c){
    $name = explode(" ", $c);
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    if (sizeof($name)==2){
        $query = "SELECT * From Public WHERE (nom LIKE '%".$name[0]."%') OR (nom LIKE '%".$name[1]."%') OR (prenom LIKE '%".$name[0]."%') OR (prenom LIKE '%".$name[1]."%')  ";
        $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    }else{
        $query = "SELECT * From Public WHERE (nom LIKE '%".$name[0]."%') OR (prenom LIKE '%".$name[0]."%')";
        $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    }


    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            $nom = convertUser($row['idPublic']);
            //echo("<li class='resR'><a onclick='autreProfil(".$row['idPublic'].")'>".$nom['nom']." ".$nom['prenom']."</a></li>");
            echo("<li class='resR'>".$nom['nom']." ".$nom['prenom']."</li>");
        }
        }else {
            echo "Utilisateur introuvable";
        }
    mysqli_close($conn);
    deconnecterBDD($db);
}

function getMessage($idMessage){
    $Signalement[] = [];
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    if ($idMessage==0){
        return "Aucun";
    }else{
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        }
        $query = "SELECT * From Message WHERE (idMessage = $idMessage)";
        $res = mysqli_query($conn, $query) or die('Request error : '.$query);
        if (mysqli_num_rows($res) > 0) {
            while($row = mysqli_fetch_assoc($res)) {
                return($row['content']);
            }
        }else {
            echo "error_1";
        }
    mysqli_close($conn);
    deconnecterBDD($db);
    }
}

function listerSignal(){
    $Signalement[] = [];
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * From Signalement ORDER BY dt DESC";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
           $Signalement[] = array('idSignaleur' => $row['idSignaleur'],'idSignalé' => $row['idSignaleur'],'NomSignaleur' => convertUser($row['idSignaleur'])['nom'],'PrénomSignaleur' => convertUser($row['idSignaleur'])['prenom'],'NomSignalé' => convertUser($row['idSignale'])['nom'],'PrénomSignalé' => convertUser($row['idSignale'])['prenom'] ,'Motif' => $row['motif'], 'Message' => getMessage($row['idMessage']), 'Date' => $row['dt']);
        }
        }else {
            echo "error_1";
        }
    mysqli_close($conn);
    deconnecterBDD($db);
    initSignal($Signalement);
    return $Signalement;
}

function Admin($idU){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * FROM Utilisateur WHERE (idUtilisateur = $idU) AND (Admin = 1)";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    mysqli_close($conn);
    deconnecterBDD($db);
    return (mysqli_num_rows($res) > 0);
}

function listerConversation($idUtilisateur){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT  COUNT(*) AS nbr_doublon, idEmetteur, idDestinataire  FROM Message GROUP BY idEmetteur, idDestinataire HAVING COUNT(*) > 1";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            if ($idUtilisateur == $row['idEmetteur'])
            {
                echo("<div class='chat_list'>
                        <div class='chat_poeple'>
                            <div class='conv chat_ib' onclick='conversation(".$row['idEmetteur'].",".$row['idDestinataire'].",".$idUtilisateur.")'>
                                <h5>".
                                    convertUser($row['idDestinataire'])['nom']." ".convertUser($row['idDestinataire'])['prenom'].
                                "</h5>
                                </div>
                            </div>
                        </div>");
            }else{

            }
        }
    }else {
        echo "No results";
    }
    mysqli_close($conn);
    deconnecterBDD($db);
}

function getConversation($idU1,$idU2,$idU){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * From Message WHERE ((idEmetteur = $idU1) AND (idDestinataire = $idU2)) OR ((idEmetteur = $idU2) AND (idDestinataire = $idU1)) ORDER BY dt";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            if ($row['idEmetteur']==$idU){
                echo("<div class='outgoing_msg em'>Vous :<div class='sent_msg Mco'><p>".$row['content']."</p><span class='time_date'>".$row['dt']."</span></div></div>");
            }else{
               echo("<div class='incoming_msg dest'>".convertUser($row['idEmetteur'])['prenom']." :<div class='received_msg Mco'><div class='received_withd_msg'><p>".$row['content']."</p><span class='time_date'>".$row['dt']."</span></div></div></div><div class='signalM'><div id='signal".$row['idMessage']."'><input type='button' onclick='signalM(".$row['idMessage'].",".$idU.",".$idU2.")' value='signaler ☛'></div></div>");
            }
        }
    }else {
        echo "No results";
    }
    mysqli_close($conn);
    deconnecterBDD($db);
}

function envoyerMessage($idEmetteur,$idDestinataire,$content){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "INSERT INTO Message (dt,idEmetteur,idDestinataire,content) VALUES (NOW(),$idEmetteur,$idDestinataire,'$content')";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    mysqli_close($conn);
    deconnecterBDD($db);
}

function annulerD($idDemandeur,$idDecideur){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "DELETE from Demande WHERE (idDemandeur,idDecideur)=($idDemandeur,$idDecideur)";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    mysqli_close($conn);
    deconnecterBDD($db);
    echo '<meta http-equiv="refresh" content="0;URL=notif.php">';
}

function accepterD($idDemandeur,$idDecideur){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "INSERT INTO Amis (idAmi1,idAmi2) VALUES ($idDemandeur,$idDecideur)";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    mysqli_close($conn);
    deconnecterBDD($db);
    annulerD($idDemandeur,idDecideur);
}

function getnotif($idUtilisateur){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * FROM Demande WHERE (idDemandeur = $idUtilisateur) OR (idDecideur = $idUtilisateur)";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            if ($idUtilisateur == $row['idDemandeur']){
                echo ("<div class='demandeNa'>".convertUser($row['idDecideur'])['nom']." ".convertUser($row['idDecideur'])['prenom']." n'a pas encore accepté votre demande d'ami <input type='button' value='Annuler la demande' onclick='annulerD(".$row['idDemandeur'].",".$row['idDecideur'].")'>
                </div>");
            }else{
                echo ("<div class='demande'>".convertUser($row['idDemandeur'])['nom']." ".convertUser($row['idDemandeur'])['prenom']." vous demande en ami! <input type='button' value='Accepter' onclick='accepterD(".$row['idDemandeur'].",".$row['idDecideur'].")'><input type='button' value='Refuser' onclick='annulerD(".$row['idDemandeur'].",".$row['idDecideur'].")'>
                </div>");
            }
        }
    }else {
        echo "Aucune notification";
    }
    mysqli_close($conn);
    deconnecterBDD($db);
}

function vsignalM($idMessage,$idUtilisateur,$motif,$idU2){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "INSERT INTO Signalement (dt,idMessage,idSignaleur,idSignale,motif) VALUES (NOW(),$idMessage,$idUtilisateur,$idU2,'$motif')";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    mysqli_close($conn);
    deconnecterBDD($db);
}

function listerNConversation($idU){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * FROM Amis WHERE (idAmi1 = $idU) OR (idAmi2 = $idU)";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            if ($idU == $row['idAmi1'])
            {
                echo("<span class='Nconv' onclick='send(".$row['idAmi1'].",".$row['idAmi2'].")'>".(convertUser($row['idAmi2']))['nom']." ".(convertUser($row['idAmi2']))['prenom']."</span>");
            }else{
                echo("<span class='conv' onclick='send(".$row['idAmi2'].",".$row['idAmi1'].")'>".(convertUser($row['idAmi1']))['nom']." ".(convertUser($row['idAmi1']))['prenom']."</span>");
            }
        }
    }else {
        echo "No results";
    }
    mysqli_close($conn);
    deconnecterBDD($db);
}

function listerNConversationA($idU){
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query = "SELECT * FROM Utilisateur";
    $res = mysqli_query($conn, $query) or die('Request error : '.$query);
    if (mysqli_num_rows($res) > 0) {
        while($row = mysqli_fetch_assoc($res)) {
            if ($idU == $row['idUtilisateur']){

            }else{
                echo("<span class='Nconv' onclick='send($idU,".$row['idUtilisateur'].")'>".(convertUser($row['idUtilisateur']))['nom']." ".(convertUser($row['idUtilisateur']))['prenom']."</span>");
            }
        }
    }else {
        echo "No results";
    }
    mysqli_close($conn);
    deconnecterBDD($db);
}

?>

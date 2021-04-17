<?php
    require 'util1.php';
    $db = connecterBDD("127.0.0.1", "root", "");
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "projet";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT * From Privee";
    $sql2 = "SELECT * From Public";
    $req = mysqli_query($db, $sql) or die ('Pb req publications : '.$sql);
    $req2 = mysqli_query($db, $sql2) or die ('Pb req publications : '.$sql2);
    $i = 0;
    $j = 0;
    if (mysqli_num_rows($req) > 0 && mysqli_num_rows($req2) > 0) {
        while($row = mysqli_fetch_assoc($req)) {
            $lstUtil2[$i]=$row;
            $i++;
        }
        while ($row2 = mysqli_fetch_assoc($req2)) {
            $lstUtil1[$j]=$row2;
            $j++;
        }
    }else {
        echo "No results";
    }
    for ($i=0; $i<sizeof($lstUtil1);$i++) {
        if (sizeof($lstUtil1)==sizeof($lstUtil2)) {
            $lstUtil[$i][] = $lstUtil1[$i]+$lstUtil2[$i];
        }
    }
    $relou = "Supprimer l\'utilisateur";
    $res = "";
    $colonnes = [];
    switch (1==1) {
        case ((!isset($_POST['mdp'])) && (!isset($_POST['i']))):
            for ($i=0; $i<sizeof($lstUtil);$i++) {
                $res .= "<div><table><thead><tr>";
                foreach($lstUtil[0][0] as $col=>$valeur) {
                    $res .= "<th>";
                    $res .= $col;
                    $res .= "</th>";
                    array_push($colonnes, $col);
                }
                $res .= "</tr></thead>";
                for ($i=0; $i<sizeof($lstUtil);$i++) {
                    foreach($lstUtil[$i] as $element) {
                        $res .= "<tr><div>";
                        foreach ($colonnes as $col) {
                            $res .= "<td>";
                            $res .= "<input name='utilisateur".$i."' type='text' value='".$element[$col]."'></input>";
                            $res .= "</td>";
                        }
                        $res .= "</div></tr>";
                    }
                    $res .= "<tr><td>";
                    $res .= "<input type='button' value='Valider les modifications' onclick='modif(".$i.")'></input>";
                    $res .= "</td><td>";
                    $res .= '<input type="button" value="Supprimer l\'utilisateur" onclick="deleteUtil('.$i.')"></input>';
                    $res .= "</td><td>";
                    $res .= '<input type="button" value="Voir les messages" onclick="voirmessages('.$i.')"></input>';
                    $res .= "</td></tr>";
                }
                $res .= "</table></div>";
            }
            break;
        case (isset($_POST['mdp'])):
            for ($i=0; $i<sizeof($lstUtil);$i++) {
                $res .= "<div><table><thead><tr>";
                foreach($lstUtil[0][0] as $col=>$valeur) {
                    $res .= "<th>";
                    $res .= $col;
                    $res .= "</th>";
                    array_push($colonnes, $col);
                }
                $res .= "</tr></thead>";
                for ($i=0; $i<sizeof($lstUtil);$i++) {
                    if ($i==$_POST['i']) {
                        $res .= "<tr><div>";
                        $res .= "<td>";
                        $res .= "<input name='utilisateur".$_POST['i']."' type='text' value='".$_POST['idPublic']."'></input>";
                        $res .= "</td>";
                        $res .= "<td>";
                        $res .= "<input name='utilisateur".$_POST['i']."' type='text' value='".$_POST['nom']."'></input>";
                        $res .= "</td>";
                        $res .= "<td>";
                        $res .= "<input name='utilisateur".$_POST['i']."' type='text' value='".$_POST['prenom']."'></input>";
                        $res .= "</td>";
                        $res .= "<td>";
                        $res .= "<input name='utilisateur".$_POST['i']."' type='text' value='".$_POST['login']."'></input>";
                        $res .= "</td>";
                        $res .= "<td>";
                        $res .= "<input name='utilisateur".$_POST['i']."' type='text' value='".$_POST['sexe']."'></input>";
                        $res .= "</td>";
                        $res .= "<td>";
                        $res .= "<input name='utilisateur".$_POST['i']."' type='text' value='".$_POST['ville']."'></input>";
                        $res .= "</td>";
                        $res .= "<td>";
                        $res .= "<input name='utilisateur".$_POST['i']."' type='text' value='".$_POST['job']."'></input>";
                        $res .= "</td>";
                        $res .= "<td>";
                        $res .= "<input name='utilisateur".$_POST['i']."' type='text' value='".$_POST['idpdp']."'></input>";
                        $res .= "</td>";
                        $res .= "<td>";
                        $res .= "<input name='utilisateur".$_POST['i']."' type='text' value='".$_POST['ddn']."'></input>";
                        $res .= "</td>";
                        $res .= "<td>";
                        $res .= "<input name='utilisateur".$_POST['i']."' type='text' value='".$_POST['idPrivee']."'></input>";
                        $res .= "</td>";
                        $res .= "<td>";
                        $res .= "<input name='utilisateur".$_POST['i']."' type='text' value='".$_POST['mdp']."'></input>";
                        $res .= "</td>";
                        $res .= "<td>";
                        $res .= "<input name='utilisateur".$_POST['i']."' type='text' value='".$_POST['email']."'></input>";
                        $res .= "</td>";
                        $res .= "</div></tr>";
                        $newsql = "UPDATE Privee, Public, Utilisateur SET nom ='".$_POST['nom']."', prenom ='".$_POST['prenom']."', mail ='".$_POST['login']."', sexe ='".$_POST['sexe']."', ville ='".$_POST['ville']."', job ='".$_POST['job']."', idpdp ='".$_POST['idpdp']."', ddn ='".$_POST['ddn']."', mdp ='".$_POST['mdp']."', email ='".$_POST['email']."' WHERE Public.idPublic='".$_POST['idPublic']."' AND Privee.idPrivee='".$_POST['idPublic']."'";
                    $newreq = mysqli_query($db, $newsql) or die ('Pb req publications : '.$newsql);
                    } else {
                        foreach($lstUtil[$i] as $element) {
                        $res .= "<tr><div>";
                            foreach ($colonnes as $col) {
                                $res .= "<td>";
                                $res .= "<input name='utilisateur".$i."' type='text' value='".$element[$col]."'></input>";
                                $res .= "</td>";
                            }
                            $res .= "</div></tr>";
                        }
                    }
                    $res .= "<tr><td>";
                    $res .= "<input type='button' value='Valider les modifications' onclick='modif(".$i.")'></input>";
                    $res .= "</td><td>";
                    $res .= '<input type="button" value="Supprimer l\'utilisateur" onclick="deleteUtil('.$i.')"></input>';
                    $res .= "</td><td>";
                    $res .= '<input type="button" value="Voir les messages" onclick="voirmessages('.$i.')"></input>';
                    $res .= "</td></tr>";
                }
                $res .= "</table></div>";
            }
            break;
        case (isset($_POST['idPrivee']) && isset($_POST['idPublic'])):
            for ($i=0; $i<sizeof($lstUtil);$i++) {
                $res .= "<div><table><thead><tr>";
                foreach($lstUtil[0][0] as $col=>$valeur) {
                    $res .= "<th>";
                    $res .= $col;
                    $res .= "</th>";
                    array_push($colonnes, $col);
                }
                $res .= "</tr></thead>";
                for ($i=0; $i<sizeof($lstUtil);$i++) {
                    if ($i==$_POST['i']) {
                        $newsql2 = "DELETE FROM Privee WHERE Privee.idPrivee='".$_POST['idPrivee']."'";
                        $newsql3 = "DELETE FROM Public WHERE Public.idPublic='".$_POST['idPublic']."'";
                        $newsql4 = "DELETE FROM Utilisateur WHERE Utilisateur.idPublic='".$_POST['idPublic']."' AND Utilisateur.idPrivee='".$_POST['idPrivee']."'";
                        $newreq = mysqli_query($db, $newsql2) or die ('Pb req publications : '.$newsql2);
                        $newreq = mysqli_query($db, $newsql3) or die ('Pb req publications : '.$newsql3);
                        $newreq = mysqli_query($db, $newsql4) or die ('Pb req publications : '.$newsql4);
                    } else {
                        foreach($lstUtil[$i] as $element) {
                        $res .= "<tr><div>";
                            foreach ($colonnes as $col) {
                                $res .= "<td>";
                                $res .= "<input name='utilisateur".$i."' type='text' value='".$element[$col]."'></input>";
                                $res .= "</td>";
                            }
                            $res .= "</div></tr>";
                        }
                        $res .= "<tr><td>";
                        $res .= "<input type='button' value='Valider les modifications' onclick='modif(".$i.")'></input>";
                        $res .= "</td><td>";
                        $res .= '<input type="button" value="Supprimer l\'utilisateur" onclick="deleteUtil('.$i.')"></input>';
                        $res .= "</td><td>";
                        $res .= '<input type="button" value="Voir les messages" onclick="voirmessages('.$i.')"></input>';
                        $res .= "</td></tr>";
                    }
                }
                $res .= "</table></div>";
            }
            break;
    }
    echo $res;
    deconnecterBDD($db);
?>

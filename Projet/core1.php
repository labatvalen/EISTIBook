<?php

   function connecterBDD($server, $user, $pass) {

       $DBconn = mysqli_connect($server, $user, $pass);
       if (!$DBconn) {
           die("Erreur: " . mysqli_connect_error());
       }
       return $DBconn;
   }

   function deconnecterBDD($DBconn) {
       if (isset($DBconn)) {
           mysqli_close($DBconn);
       }
    }
    
    function tableauToHTML($tab) {
        if ( count($tab) <=0 ) {
            return NULL;
        }
        $res = "";
        $res .= "<div>";
        $colonnes = [];
        $res .= "<thead><tr>";
        foreach($tab[0] as $col=>$valeur) {
            $res .= "<th>";
            $res .= $col;
            $res .= "</th>";
            array_push($colonnes, $col);
        }
        $res .= "</tr></thead>";
        foreach($tab as $element) {
            $res .= "<tr>";
            foreach ($colonnes as $col) {
                $res .= "<td>";
                $res .= $element[$col];
                $res .= "</td>";
            }
            $res .= "</tr>";
        }
        $res .= "</table>";
        return $res;
    }

    function initPublication($tab){
        //print_r($tab);
        echo ("<div class='panel panel-default'>");
        if (isset($tab['Nom']))
        {
            echo("<div class=".'"panel-heading"'.">".$tab['Nom']." ".$tab['Prénom']."</div>");
        }
        if (isset($tab['Date de publication']))
        {
            echo("<div class='dateP'>".$tab['Date de publication']."</div>");
        }
        if (isset($tab['Contenu']))
        {
            echo("<div class=".'"panel-body"'.">".$tab['Contenu']."</div>");
        }
        if (isset($tab['Photo']))
        {
            echo("<div class=".'"pdp"'.">".$tab['Photo']."</div>");
        }
        if (isset($tab['Image']))
        {
            echo("<div class=".'"panel-body img-rounded"'.">".$tab['Image']."</div>");
        }
        if (isset($tab['J\'aime']))
        {
            echo("<div class=".'"panel-body likes"'." id='L".$tab['idPublication']."' >".$tab['J\'aime']."</div>");
        }
        if (isset($tab['Signaler']))
        {
            echo("<div class='Signal panel-group'><div class='panel-heading'><h4 class='panel_title'>".$tab['Signaler']."</h4></div><div id='signal".$tab['idPublication']."'></div></div>");
        }
        if (isset($tab['Supprimer']))
        {
            echo("<div class='Supp'>".$tab['Supprimer']."</div>");
        }
        echo ("<div id='signal".$tab['idPublication']."'></div>");
        echo ("<div id='delet".$tab['idPublication']."'></div>");
        echo ("</div>");
    }
    
      function initSignalement($tab){
        echo ("<div class='signaux'>");
        if (isset($tab['NomSignaleur']))
        {
            echo("<div class=".'"nomS"'.">".$tab['NomSignaleur']." ".$tab['PrénomSignaleur']."</div>");
        }
        if (isset($tab['NomSignalé']))
        {
            echo("<div class=".'"nomS"'.">à signalé: ".$tab['NomSignalé']." ".$tab['PrénomSignalé']."</div>");
        }
        if (isset($tab['Date']))
        {
            echo("<div class='datePS'> ".$tab['Date']."</div>");
        }
        if (isset($tab['Motif']))
        {
            echo("<div class=".'"motifS"'.">car: ".$tab['Motif']."</div><br>");
        }
        if (isset($tab['Message']))
        {
            echo("<div class=".'"messageS"'.">Message: ".$tab['Message']."</div><br>");
        }
        if (isset($tab['Supprimer']))
        {
            echo("<div class='SuppS'>".$tab['Supprimer']."</div>");
        }
        echo ("</div>");
    }
     
    function initWall($Publications){
        if ( count($Publications) <=0 ) {
            return NULL;
        }
        //print_r($Publications);
        foreach ($Publications as $p) {
            initPublication($p);
        }   
    
    }
    
    function initSignal($signal){
        if ( count($signal) <=0 ) {
            return NULL;
        }
        //print_r($Publications);
        foreach ($signal as $s) {
            initSignalement($s);
        }   
    
    }
?>
    
    

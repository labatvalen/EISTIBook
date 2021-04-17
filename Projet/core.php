<?php
//fonctions de connection et deconnection à la BDD principalement
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
       $res .= "<table>";

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

   ?>

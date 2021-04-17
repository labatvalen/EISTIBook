<?php
    require("util1.php");
    envoyerMessage($_GET['e'],$_GET['d'],$_GET['c']);
    echo("<div class='em'>Vous :<div class='Mco'>".$_GET['c']."</div></div><div class='signalM'></div>");
?>

<?php
    echo("
        <input type='text' id='motifSM".$_GET['idM']."' placeholder='Motif du signalement'>
        <input type='button' onclick='vsignalM(".$_GET['idM'].",".$_GET['idU'].",".$_GET['idU2'].")' value='Valider'>
        <input type='button' onclick='closeSM(".$_GET['idM'].",".$_GET['idU'].")' value='❌'>
        ");
?>
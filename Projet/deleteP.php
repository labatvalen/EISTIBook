<?php
    echo("
        <div id='formul".$_GET['d']."'>
            Ceette suppression sera définitive
            <input type='button' value='valider' onclick='vdeleteP(".$_GET['d'].")'>
            <input type='button' value='❌' onclick='closeD(".$_GET['d'].")'>
        </div>
        ");
?>
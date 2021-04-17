<?php
    echo("
        <div class='formul' id='formul".$_GET['p']."'>
            <input class='panel-body' panel- type='text' id='motif".$_GET['p']."' placeholder='Motif du signalement'>
            <input type='button' value='valider' onclick='vsignalP(".$_GET['p'].",".$_GET['u'].",".$_GET['us'].")'>
            <button class='croix' onclick='closeS(".$_GET['p'].")'>❌</button>
        </div>
        ");
?>
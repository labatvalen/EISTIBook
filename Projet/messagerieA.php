<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head lang="fr">
        <meta charset="UTF-8">
        <title>Site</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='style.css' rel="stylesheet" type="text/css">
        <script type="text/javascript" src="ajax.js"></script>
    </head>
    <body>
        <div id="navigation">
            <ul>
                <li>
                    <img id="logo" src="logo_eistibook.png">
                </li>
                <li class="recherche_p">
                    <input id="search" name="q" type="text" placeholder="Rechercher un utilisateur" />
                    <input type="image" id="search-btn" alt="Login" src="loupe.png" onclick="rechercher()">
                </li>

                <li class="lien"><a class="active" href="#">Deconexion</a></li>
                <li class="lien"><a href="notif.php">Notif</a></li>
                <li class="lien"><a href="messagerie.php">Message</a></li>
                <li class="lien"><a href="profil.php">Profil</a></li>
                <li class="lien"><a href="filactu.php">Acceuil</a></li>
            </ul>
        </div>
        <ul id="i">
        </ul>
        <div id="Conversation" >
            <?php
            require("util1.php");

            error_reporting(-1);
            ini_set('display_errors', 'On');

            listerConversation($SESSION['id']);
            ?>
        </div>
        <div id="messages">
        </div>
        <div id="NConversation">
            <?php
            listerNConversationA($SESSION['id'];
            ?>
        </div>
        <div id="res">
        </div>
    </body>
</html>

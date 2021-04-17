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
        <div>
            <ul id="navigation">
                <li class="nav" style="float:left">
                    <img id="logo" src="logo_eistibook.png">
                </li>
                <li class="nav" style="float:right"><a class="active" href="#">deconexion</a></li>
                <li class="nav" style="float:right"><a href="signalement.php">Signalements</a></li>
                <li class="nav" style="float:right"><a href="lstUtil.php">Utilisateurs</a></li>
                <li class="nav" style="float:right"><a href="messages.php">Messages</a></li>
            </ul>
        </div>
        <div class="recherche_p">
            <input id="search" name="q" type="text" placeholder="Rechercher" />
            <input type="button" value="Rechercher" onclick="recherche()">
            <ul id="i">
            </ul>
        </div>
        <div id="res">
        </div>
    </body>
</html>
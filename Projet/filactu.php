<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head lang="fr">
        <meta charset="UTF-8">
        <title>Site</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="ajax.js"></script>
        <link href='style1.css' rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Eisti'book</a>
                </div>
                <ul class="nav navbar-nav">
                  <li class="active"><a href="filactu.php">Accueil</a></li>
                  <li><a href="messagerie.php"><span class="glyphicon glyphicon-envelope"></span></a></li>
                  <li><a href="profil.php">Profil</a></li>
                  <li><a href="notif.php">Notification</a></li>
                  <li><a href="amis.php">Amis</a></li>
                  <li><a href='connectinscrip.php'>Déconnexion</a></li>
                </ul>
                <form class="navbar-form navbar-left" method="get" action="recherche.php">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search" name="search">
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <ul id="i">
        </ul>
        <div class="col-md-6 gedf-main" id="publier">
                <input type="text" id="publication_content" placeholder="Publier quelque chose...">
                <?php echo '<input type="button" value="publier" onclick="publierFA('.$_SESSION['id'].')">';?>
                <!--<input id="fileToUpload" type="file" name="fileToUpload">-->
                <div id="test"></div>
            </div>
        <div class="container">
            <div id="mur" >
                <?php
                require("util.php");

                error_reporting(-1);
                ini_set('display_errors', 'On');

                $tab = getPublications($_SESSION['id']);
                ?>
            </div>
            <div id="res">
            </div>
        </div>

    </body>
</html>

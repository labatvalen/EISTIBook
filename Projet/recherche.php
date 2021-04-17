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
                    <li class="active"><a href="filactu.php">Acceuil</a></li>
                    <li><a href="messagerie.php"><span class="glyphicon glyphicon-envelope"></span></a></li>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="notif.php">Notification</a></li>
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
        <div class="container">
            <h3 class="text-center">Recherche</h3>
            <div id="rechercheR">
                <?php
                require("util1.php");
                error_reporting(-1);
                ini_set('display_errors', 'On');
                echo (rechercher($_GET['search']));
                ?>
            </div>
        </div>
        <div id="res">
        </div>
    </body>
</html>

<!DOCTYPE html>
<html>
    <head lang="fr">
        <meta charset="UTF-8">
        <title>Site</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='forme.css' rel="stylesheet" type="text/css">
        <script type="text/javascript" src="ajax.js"></script>
    </head>
    <body>
        <div id='titre'>
            EISTIBOOK
        </div>
        <div id='soustitre'>
            Fil d'actualité
        </div>
        <div class="recherche">
            <form class="example" style="margin:auto;max-width:300px">
                <input type="text" id="rBar" placeholder="Rechercher un utilisateur" name="search">
                <button type="submit" onclick="recherche()"><i class="fa fa-search"></i></button>
                <div id="resR">
                </div>
            </form>
        </div>
        <div id="mur" >
        </div>
        <div id="res">
        </div>
    </body>
</html>

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./script/php/function.php');
?>

<!doctype html>
<html lang="fr">
    <head>

        <meta charset="utf-8">
        <title>Recettes</title>      
        <link href="script/css/bootstrap.min.css" rel="stylesheet">

        <link href="script/css/style.css" rel="stylesheet">

    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top">
            <?php include "liens_menu.php"; ?>    
        </nav>
        <header class="container page-header">
            <h1 >TopRecettes <small>Recettes</small></h1>
        </header>
        <section>
            <div class="container contenu">
                <div class="col-sm-12">
                    <div class="page-header">
                        <!-- formualire de recherche -->
                        <form class="form" role="search" action="#" method="get">
                            <div class="row">
                                <!-- select de trie-->
                                <div class="col-md-4 col-md-offset-1 col-sm-6 col-xs-6">
                                    <div class="input-group">
                                        <select type="text" class="form-control" name="">
                                            <option value="0">Trier les recettes</option>
                                            <option>Plus récentes</option>
                                            <option>Plus anciennes</option>
                                            <option>Meilleures notes</option>
                                            <option>Moins bonne notes </option>
                                        </select>
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default">
                                                <img class="glyph" src="glyphicons_free/glyphicons/glyphicons-28-search.png">
                                            </button>
                                        </span>
                                    </div>
                                </div>

                                <!-- input de recherche -->
                                <div class="col-md-4 col-md-offset-1 col-sm-6 col-xs-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="" placeholder="Rechercher">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default">
                                                <img class="glyph" src="glyphicons_free/glyphicons/glyphicons-28-search.png">
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-md-3 col-sm-4 col-xs-6">
                        <div class="thumbnail">
                            <a href="" class="post-image-link">
                                <p><img src="130 MX.jpg" class="img-responsive" alt=""></p>

                            </a>
                            <div class="caption">
                                <h3>Creative</h3>
                                <p>A one page creative theme.</p>
                                <p>A one page creative theme.</p>
                                <p>A one page creative theme.</p>
                                <p>A one page creative theme.</p>
                                <a href="" class="btn btn-default">Voir</a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

    <footer class="container">
        <p class="navbar-text">
            Cedric Dos Reis - CFPT 2015 
        </p>
    </footer>

    <script src="script/js/jquery.js"></script>
    <script src="script/js/bootstrap.min.js"></script>

</body>
</html>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./script/php/function.php');

$search = NULL;
$sort = NULL;

$title = 'Recettes';

//test les parametre dans l'url 
if ((isset($_GET['sort'])) or (isset($_GET['search']))) {
    if ((isset($_GET['search'])) AND (!empty($_GET['search']))) {
        $recipes = get_recipes($_GET['sort'], $_GET['search']);

        $search = $_GET['search'];
        $sort = $_GET['sort'];
    } else {
        $recipes = get_recipes($_GET['sort'], NULL);
    }
} else {
    $recipes = get_recipes(NULL, NULL);
}

switch ($sort) {
    case 1: $title = 'Recettes - Plus récentes';
    case 2: $title = 'Recettes - Plus anciennes';
    case 3: $title = 'Recettes - Mieux notées';
    case 4: $title = 'Recettes - Moins bien notées';
}

var_dump_pre($recipes);
var_dump_pre($search);
var_dump_pre($sort);
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
            <h1 >TopRecettes <small><?= $title ?></small></h1>
        </header>
        <section>
            <div class="container contenu">
                <div class="col-sm-12">
                    <div class="page-header">

                        <!-- formualire de recherche -->
                        <form class="form" role="search" action="recettes.php" method="get">
                            <div class="row">
                                <!-- select de trie-->
                                <div class="col-md-4 col-md-offset-1 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label" for="sort">Trier les recettes</label>
                                        <div class="input-group">
                                            <select name="sort" id="sort" class="form-control" autofocus="<?= $sort; ?>">
                                                <option value="">Pas de tri</option>
                                                <option value="1">Plus récentes</option>
                                                <option value="2">Plus anciennes</option>
                                                <option value="3">Meilleures notes</option>
                                                <option value="4">Moins bonne notes </option>
                                            </select>
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-default">
                                                    <img class="glyph" src="glyphicons_free/glyphicons/glyphicons-28-search.png">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- input de recherche -->

                                <div class="col-md-4 col-md-offset-1 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label" for="search">Recherche</label>
                                        <div class="input-group">
                                            <input type="text" name="search" id="search" value="<?= $search; ?>" class="form-control" name="" placeholder="Rechercher">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-default">
                                                    <img class="glyph" src="glyphicons_free/glyphicons/glyphicons-28-search.png">
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>


                    <!-- Affiche la liste des recettes -->
                    <?php if (empty($recipes)) { //Affiche un message d'erreur?>
                        <p style="text-align : center;">Ancune recette n'a été trouvée.</p>
                    <?php } ?>
                    <?php foreach ($recipes as $recipe) { ?>
                        <div class="col-md-3 col-sm-4 col-xs-6">
                            <div class="thumbnail">
                                <a href="recette.php?id=<?= $recipe['idRecipe']; ?>" class="post-image-link">
                                    <p><img src="<?= $recipe['RecipeImage']; ?>" class="img-responsive" alt=""></p>

                                </a>
                                <div class="caption">
                                    <h3><?= $recipe['RecipeTitle']; ?></h3>
                                    <p>Auteur : <?= $recipe['UserPseudo']; ?></p>
                                    <p>Date d'ajout : <?= $recipe['RecipeDate']; ?></p>
                                    <a href="recette.php?id=<?= $recipe['idRecipe']; ?>" class="btn btn-default">Voir</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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
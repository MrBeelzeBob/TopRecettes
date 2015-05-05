<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./script/php/function.php');

$recherche = NULL;
$tri = NULL;
$connected = FALSE;
$idUser = NULL;

$title = 'Recettes';

//test si un utilisateur est connecté
if ((isset($_SESSION['idUser'])) AND ( isset($_SESSION['UserPseudo']))) {
    $connected = true;
    $idUser = $_SESSION['idUser'];
}

//test les parametre dans l'url 
if ((isset($_GET['tri'])) or (isset($_GET['recherche']))) {

    if ((isset($_GET['recherche'])) AND (!empty($_GET['recherche']))) {

        $recipes = get_recipes($_GET['tri'], $_GET['recherche'], $idUser);
        $search = $_GET['recherche'];
        $tri = $_GET['tri'];
    } else {
        $recipes = get_recipes($_GET['tri'], NULL, $idUser);
        $tri = $_GET['tri'];
    }
} else {
    $recipes = get_recipes(NULL, NULL, $idUser);
}

//Modifie le titre selon le tri efféctué
switch ($tri) {
    case 1: $title = 'Recettes - Plus récentes';
    case 2: $title = 'Recettes - Plus anciennes';
    case 3: $title = 'Recettes - Mieux notées';
    case 4: $title = 'Recettes - Moins bien notées';
    case 5: $title = 'Recettes - Mes recettes';
}

var_dump_pre($recipes);
var_dump_pre($recherche);
var_dump_pre($tri);
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
                                            <select name="tri" id="tri" class="form-control" autofocus="<?= $sort; ?>">
                                                <option value="">Pas de tri</option>
                                                <option value="1">Plus récentes</option>
                                                <option value="2">Plus anciennes</option>
                                                <option value="3">Meilleures notes</option>
                                                <option value="4">Moins bonne notes</option>
                                                <?php if ($connected) { ?>
                                                    <option value="5">Mes recettes</option>
                                                <?php } ?>

                                            </select>
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-default">
                                                    <img class="glyph" src="glyphicons_free/glyphicons/glyphicons-28-search.png">
                                                </button>
                                            </span>

                                        </div>
                                    </div>
                                </div>

                                <!-- input de recherche  ol-md-4 col-md-offset- col-sm-6 col-xs-6 -->

                                <div class="col-md-4 col-md-offset-1 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label" for="search">Recherche</label>
                                        <div class="input-group">
                                            <input type="text" name="recherche" id="recherche" value="<?= $recherche; ?>" class="form-control" name="" placeholder="Rechercher...">
                                            <span class="input-group-btn">
                                                <button type="submit" class="btn btn-default">
                                                    <img class="glyph" src="glyphicons_free/glyphicons/glyphicons-28-search.png">
                                                </button>
                                                <a class="btn btn-warning" href="recettes.php">Annuler</a>
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
                                <div class="caption-full">
                                    <h3><?= $recipe['RecipeTitle']; ?></h3>
                                    <p>Auteur : 
                                        <?php
                                        if (!$recipe['idUser']) {
                                            echo 'Utilisateur supprimé';
                                        } else {
                                            $pseudo = get_user_pseudo($recipe['idUser']);
                                            echo $pseudo['UserPseudo'];
                                        }
                                        ?>
                                    </p>
                                    <p>Date d'ajout : <?= $recipe['RecipeDate']; ?></p>
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
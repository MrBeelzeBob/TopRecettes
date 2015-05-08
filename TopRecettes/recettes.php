<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./script/php/function.php');

$search = NULL;
$sort = NULL;
$connected = FALSE;
$idUser = NULL;

$TableSort = array("" => "Pas de tri", "1" => "Plus récentes", "2" => "Plus anciennes", "3" => "Meilleures notes", "4" => "Moins bonne notes");

$title = 'Liste des Recettes';

//test si un utilisateur est connecté
if (isset($_SESSION['idUser'])) {
    $connected = true;
    $idUser = $_SESSION['idUser'];
    $TableSort = array("" => "Pas de tri", "1" => "Plus récentes", "2" => "Plus anciennes",
        "3" => "Meilleures notes", "4" => "Moins bonne notes", "5" => "Mes recettes");
}

//test les parametre dans l'url 
if ((isset($_GET['sort'])) or ( isset($_GET['search']))) {

    if ((isset($_GET['search'])) AND (!empty($_GET['search']))) {

        $recipes = get_recipes($_GET['sort'], $_GET['search'], $idUser, $limit = NULL);

        $search = $_GET['search']; //utilisater pour définir la valeur dans le formulaire
        $sort = $_GET['sort']; //utilisater pour définir la valeur dans le formulaire
    } else {
        $recipes = get_recipes($_GET['sort'], NULL, $idUser, $limit = NULL);
        $sort = $_GET['sort']; //utilisater pour définir la valeur dans le formulaire
    }
} else {
    $recipes = get_recipes(NULL, NULL, $idUser, $limit = NULL);
}

//Modifie le titre selon le tri efféctué
switch ($sort) {
    case 1: $title = 'Recettes - Plus récentes';
    case 2: $title = 'Recettes - Plus anciennes';
    case 3: $title = 'Recettes - Mieux notées';
    case 4: $title = 'Recettes - Moins bien notées';
    case 5: $title = 'Recettes - Mes recettes';
}
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
                        <h2 class="text-center">Liste des recettes</h2>
                    </div>

                    <!-- formualire de recherche -->
                    <form class="form col-md-12 center-block" role="search" action="recettes.php" method="get">
                        <div class="row">

                            <div class="form-group col-md-2">
                                <h4>Recherche</h4>
                            </div>
                            <!-- input de recherche  ol-md-4 col-md-offset- col-sm-6 col-xs-6 -->
                            <div class="form-group col-sm-4">
                                <input type="text" name="search" id="search" value="<?= $search; ?>" class="form-control" name="" placeholder="Rechercher...">
                            </div>
                            <div class="form-group col-sm-4">
                                <!-- select de trie-->
                                <?php echo Select('sort', $TableSort, $sort, FALSE); ?>
                            </div>
                            <div class="form-group col-sm-2 col-xs-4">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                                <a href="recettes.php" class="btn btn-default" title="Annuler la recherche">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </div>
                        </div>
                    </form>
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
                                            echo get_user_pseudo($recipe['idUser']);
                                        }
                                        ?>
                                    </p>
                                    <p>Date d'ajout : <?= $recipe['RecipeDate']; ?></p>
                                    <p>
                                        Moyenne des notes : 
                                        <?php
                                        echo show_avg_note_recipe($recipe['RecipeAVG']);
                                        ?>
                                    </p>
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
<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015

Liste des recettes + Recherche et tri - recettes.php 
-->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./script/php/function.php');

$search = NULL;
$sort = NULL;
$connected = FALSE;
$idUser = NULL;

$TableSort = array("" => "Pas de tri", "1" => "Les plus récentes", "2" => "Les plus anciennes", "3" => "Les mieux notées", "4" => "Les moins bien notées");

$title = 'Liste des Recettes';

//test si un utilisateur est connecté
if (isset($_SESSION['idUser'])) {
    $connected = true;
    $idUser = $_SESSION['idUser'];
    $TableSort = array("" => "Pas de tri", "1" => "Plus récentes", "2" => "Plus anciennes",
        "3" => "Meilleures notes", "4" => "Moins bonne notes", "5" => "Mes recettes");
}

//test les parametre dans l'url 
if ((isset($_GET['sort'])) or ( isset($_GET['search']))) { //Test si une recherche est 
//test si les deux parametre (sort, search) sont reçus
    if ((isset($_GET['search'])) AND ( !empty($_GET['search'])) AND ( isset($_GET['sort'])) AND ( !empty($_GET['sort']))) {
        $recipes = get_recipes($_GET['sort'], $_GET['search'], $idUser, $limit = NULL);
        $search = $_GET['search'];
        $sort = $_GET['sort'];
    } else
    //test la reception d'une recherche sans tri
    if ((isset($_GET['search'])) AND ( !empty($_GET['search']))) {
        $recipes = get_recipes($sort = NULL, $_GET['search'], $idUser, $limit = NULL);
        $search = $_GET['search'];
    } else
    //test la reception dun tri sans recherche
    if ((isset($_GET['sort'])) AND ( !empty($_GET['sort']))) {
        $recipes = get_recipes($_GET['sort'], $search = NULL, $idUser, $limit = NULL);
        $sort = $_GET['sort'];
    } else
    //Test la reception d'un tri vide et d'une recherche vide
    if ((empty($_GET['sort'])) AND ( empty($_GET['search']))) {
        $recipes = get_recipes($sort = NULL, $search = NULL, $idUser, $limit = NULL);
    }
} else {
    $recipes = get_recipes($sort = NULL, $search = NULL, $idUser, $limit = NULL);
}

//Modifie le titre selon le tri efféctué
switch ($sort) {
    case 1:
        $title = 'Recettes - Plus récentes';
        break;
    case 2:
        $title = 'Recettes - Plus anciennes';
        break;
    case 3:
        $title = 'Recettes - Mieux notées';
        break;
    case 4:
        $title = 'Recettes - Moins bien notées';
        break;
    case 5:
        $title = 'Recettes - Mes recettes';
        break;
}
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Recettes - TopRecettes</title>      
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
                    <!-- formualire de recherche et tri -->
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
                    <?php if (empty($recipes)) { //Affiche un message d'erreur      ?>
                        <p style="text-align : center;">Ancune recette n'a été trouvée.</p>
                    <?php } ?>
                    <?php foreach ($recipes as $recipe) { ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 col-sm-12">
                            <a href="recette.php?id=<?= $recipe['idRecipe']; ?>" class="thumbnail post-image-link info_thumbnail">
                                <img src="<?= $recipe['RecipeImage']; ?>" class="img-responsive" alt="">
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
                            </a>
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
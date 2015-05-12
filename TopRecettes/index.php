<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015
-->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./script/php/function.php');


$toprecipes = get_recipes($sort = 3, $search = NULL, $idUser = NULL, $limit = 4);

$lastrecipes = get_recipes($sort = 1, $search = NULL, $idUser = NULL, $limit = 4)
?>

<!doctype html>
<html lang="fr">
    <head>

        <meta charset="utf-8">
        <title>Titre de la page  </title>      
        <link href="script/css/bootstrap.min.css" rel="stylesheet">
        <link href="script/css/style.css" rel="stylesheet">

    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <?php include "liens_menu.php"; ?>    
        </nav>
        <header class="container page-header">
            <h1>TopRecettes <small>Accueil</small></h1>
        </header>

        <section>
            <div class="container contenu">
                <!-- Affiche la liste des recettes -->
                <div class="col-md-6 col-sm-12">
                    <div class="page-header">
                        <h3 class="text-center">Les meilleures recettes</h3>
                    </div>
                    <?php if (empty($toprecipes)) { //Affiche un message d'erreur?>
                        <p style="text-align : center;">Ancune recette n'a été trouvée.</p>
                    <?php } ?>
                    <?php foreach ($toprecipes as $toprecipe) { ?>
                        <div class="col-xs-6">
                            <a href="recette.php?id=<?= $toprecipe['idRecipe']; ?>" class="thumbnail post-image-link info_thumbnail">
                                <img src="<?= $toprecipe['RecipeImage']; ?>" class="img-responsive" alt="">
                                <div class="caption-full">
                                    <h3><?= $toprecipe['RecipeTitle']; ?></h3>
                                    <p>Auteur : 
                                        <?php
                                        if (!$toprecipe['idUser']) {
                                            echo 'Utilisateur supprimé';
                                        } else {
                                            echo get_user_pseudo($toprecipe['idUser']);
                                        }
                                        ?>
                                    </p>
                                    <p>Date d'ajout : <?= $toprecipe['RecipeDate']; ?></p>
                                    <p>
                                        Moyenne des notes : 
                                        <?php
                                        echo show_avg_note_recipe($toprecipe['RecipeAVG']);
                                        ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-md-6 col-sm-12">
                    <div class="page-header">
                        <h3 class="text-center">Les dernières recettes</h3>
                    </div>
                    <?php if (empty($lastrecipes)) { //Affiche un message d'erreur?>
                        <p style="text-align : center;">Ancune recette n'a été trouvée.</p>
                    <?php } ?>
                    <?php foreach ($lastrecipes as $lastrecipe) { //Affiche toutes les recettes recettes récup?>
                        <div class="col-xs-6">
                            <a href="recette.php?id=<?= $lastrecipe['idRecipe']; ?>" class="thumbnail post-image-link info_thumbnail">
                                <p><img src="<?= $lastrecipe['RecipeImage']; ?>" class="img-responsive" alt=""></p>

                                <div class="caption-full">
                                    <h3><?= $lastrecipe['RecipeTitle']; ?></h3>
                                    <p>Auteur : 
                                        <?php
                                        if (!$lastrecipe['idUser']) {
                                            echo 'Utilisateur supprimé';
                                        } else {
                                            echo get_user_pseudo($lastrecipe['idUser']);
                                        }
                                        ?>
                                    </p>
                                    <p>Date d'ajout : <?= $lastrecipe['RecipeDate']; ?></p>
                                    <p>
                                        Moyenne des notes : 
                                        <?php
                                        //Affiche la moyenne des notes pour cette recette
                                        echo show_avg_note_recipe($lastrecipe['RecipeAVG']);
                                        ?>
                                    </p>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
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
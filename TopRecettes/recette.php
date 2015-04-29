<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./script/php/function.php');

//vérifie l'id
if ((isset($_GET['id'])) AND (!empty($_GET['id']))) {

    $id = $_GET['id'];

    //récupere les infos principal de la recette
    $recipe = get_recipe($id);


    //test si le jeu existe
    if ($recipe == FALSE) {
        //header('location: ./Liste.php?type=consoles');
        //exit();
        echo 'vide';
    }
    //récupere les ingrédients qui composent cette recette
    $ingredients = get_ingredients_recipe($id);

    // récupre les commentaire posté sur cette recette
    $comments = get_comments_recipe($id);

    echo 'recette';
    var_dump_pre($recipe);

    echo 'ingredient';
    var_dump_pre($ingredients);

    echo 'comments';
    var_dump_pre($comments);
} else {

    //header('location: ./Liste.php?type=consoles');
    //exit();
    echo 'erreur id';
}
?>

<!doctype html>
<html lang="fr">
    <head>

        <meta charset="utf-8">
        <title><?= $recipe['RecipeTitle'] ?> </title>      
        <link href="script/css/bootstrap.min.css" rel="stylesheet">

        <link href="script/css/style.css" rel="stylesheet">

    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <?php include "liens_menu.php"; ?>    
        </nav>
        <header class="container page-header">
            <h1>TopRecettes<small>Consulter une recette</small></h1>
        </header>

        <section>
            <div class="container contenu">
                <div class="page-header">
                    <h2 class="text-center"><?= $recipe['RecipeTitle'] ?></h2>
                </div>
                <div class="col-md-6">
                    <div class="thumbnail">
                        <img src="<?= $recipe['RecipeImage']; ?>" class="img-responsive" alt="">
                    </div>
                </div>
                
                <!-- table des ingrédients -->
                <div class="col-md-6">
                    <table style="width:100%" class="thumbnail table table-striped">
                        <thead>
                            <tr>
                                <td>Ingrédient</td>
                                <td>Quantité</td> 
                                <td>Unité</td>
                            </tr>
                        </thead>
                        <?php foreach ($ingredients as $ingredient) { ?>
                            <tr>
                                <td><?= $ingredient['IngredientName'] ?></td>
                                <td><?= $ingredient['ContainsQuantity'] ?></td> 
                                <td><?= $ingredient['ContainsUnit'] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
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
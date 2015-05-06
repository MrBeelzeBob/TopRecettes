<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./script/php/function.php');
$connected = FALSE;


//test si l'utilisateur est connecté
if (isset($_SESSION['idUser'])) {
    $isAdmin = CheckAdmin($_SESSION['idUser']);
    $connected = TRUE;
}

//vérifie l'id dans l'url
if ((isset($_GET['id'])) AND (!empty($_GET['id']))) {

    $idRecipe = $_GET['id'];

    //Ajoute un nouveau commentaire si envoyé
    if ($connected) {
        if (isset($_POST['SubmitComment'])) {
            if ((isset($_POST['UserComment'])) AND (!empty($_POST['UserComment']))) {
                add_comment($_SESSION['idUser'], $idRecipe, $_POST['UserComment']);
                header('location: #comments');
            }
        }
    }

    //récupere les infos principal de la recette
    $recipe = get_recipe($idRecipe);
    //test si la recette existe
    if ($recipe == FALSE) {
        header('location: ./recettes.php');
        exit();
    }
    //récupere les ingrédients qui composent cette recette
    $ingredients = get_ingredients_recipe($idRecipe);
    // récupre les commentaire posté sur cette recette
    $comments = get_comments_recipe($idRecipe);

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
            <h1>TopRecettes <small>Consulter une recette</small></h1>
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
                            </tr>
                        </thead>
                        <?php foreach ($ingredients as $ingredient) { ?>
                            <tr>
                                <td><?= $ingredient['IngredientName'] ?></td>
                                <td><?= $ingredient['ContainsQuantity'] ?></td> 
                            </tr>
                        <?php } ?>
                    </table>
                </div>

                <div class="col-md-8 col-md-offset-2">
                    <div class="page-header">
                        <h2 class="text-center">Préparation de la recette</h2>
                    </div>
                    <p><?= $recipe['RecipePreparation']; ?></p>
                </div>
            </div>
            <div class="container contenu">
                <!-- Commentaires -->
                <div id="comments" class="comments col-md-10 col-md-offset-1">
                    <div class="page-header">
                        <h2 class="text-center">Commentaires</h2>
                    </div>
                    <?php if ($connected) { ?>
                        <!-- formulaire d'ajout de commentaire -->

                        <form class="form col-md-12 center-block" action="#" method="post">
                            <div class="form-group col-md-8">
                                <textarea maxlength="1000" class="form-control" id="UserComment" name="UserComment" placeholder="Votre commentaire ici" required=""></textarea>
                            </div>   
                            <div class="form-group col-md-4">
                                <button class="btn btn-primary btn-block" type="submit" name="SubmitComment" id="SubmitComment" >Commenter</button>
                            </div>
                        </form>
                    <?php } ?>

                    <?php if (empty($comments)) { ?>
                        <div class="col-md-12 breadcrumb">
                            <p class="text-center"> Ancun commentaire</p>
                        </div>
                    <?php } ?>
                    <?php foreach ($comments as $comment) { ?>
                        <div class="col-md-12 breadcrumb">
                            <div class="col-md-4">
                                <p>Posté par 
                                    <b>
                                        <?php
                                        if (!$comment['idUser']) {
                                            echo 'Utilisateur supprimé';
                                        } else {
                                            $pseudo = get_user_pseudo($comment['idUser']);
                                            echo $pseudo['UserPseudo'];
                                        }
                                        ?></b>
                                </p>
                                <p>Ajouté le 
                                    <?= $comment['CommentDate'] ?>
                                </p>
                                <?php if ($isAdmin) { ?>
                                    <a href="" >Supprimer</a>
                                <?php } ?>
                            </div>
                            <div class="col-md-8">
                                <p>
                                    <?= $comment['CommentText'] ?>
                                </p>
                            </div>
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
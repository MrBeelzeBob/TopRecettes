<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015
-->
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
if ((isset($_GET['id'])) AND ( !empty($_GET['id']))) {
    $idRecipe = $_GET['id'];
    if ($connected) {
        if (isset($_POST['SubmitComment'])) {//Ajoute un nouveau commentaire si envoyé
            try {
                if ((isset($_POST['UserComment'])) AND ( !empty($_POST['UserComment']))) { //test la reception du commentaire
                    if ((isset($_POST['UserNote'])) AND ( !empty($_POST['UserNote']))) { //test si l'utilisateur note la recette
                        $UserNote = $_POST['UserNote'];
                        if (($UserNote >= 1) AND ( $UserNote <= 5)) { //test si la note est comprise entre 1 et 5
                            add_comment($_SESSION['idUser'], $idRecipe, $_POST['UserComment'], $UserNote); //Ajoute le commentaire avec la note
                        } else {
                            throw new Exception('Le commentaire n\'a pas été ajouté car la note n\'est par comprise entre 1 et 5.');
                        }
                    } else {
                        //Ajoute le commentaire sans note
                        add_comment($_SESSION['idUser'], $idRecipe, $_POST['UserComment'], NULL);
                        header('location: #comments');
                    }
                } else {
                    throw new Exception('Il n\'y pas de commentaire.');
                }
            } catch (Exception $ex) {
                ShowError('Une erreur est survenue : ' . $ex->getMessage());
            }
        }
    }
    //récupere les infos principal de la recette
    $recipe = get_recipe($idRecipe);
    //test si la recette existe <!-- COMMENTAIRES -->
    if ($recipe['idRecipe'] == FALSE) {
        header('location: ./recettes.php');
        exit();
    }
    //récupere les ingrédients qui composent cette recette
    $ingredients = get_ingredients_recipe($idRecipe);
    // récupre les commentaire posté sur cette recette
    $comments = get_comments_recipe($idRecipe);
} else {

    header('location: ./');
    exit();
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
        <!-- Titre de la page -->
        <header class="container page-header">
            <h1>TopRecettes <small>Consulter une recette</small></h1>
        </header>

        <section>
            <!-- Informations sur la recettes  -->
            <div class="container contenu">
                <div class="page-header">
                    <h2 class="text-center"><?= $recipe['RecipeTitle'] ?> <?= show_avg_note_recipe($recipe['RecipeAVG']) ?>
                </div>
                <div class="col-md-6">
                    <div class="thumbnail">
                        <!-- Image de la recette -->
                        <img src="<?= $recipe['RecipeImage']; ?>" class="img-responsive" alt="<?= $recipe['RecipeTitle']; ?>">
                    </div>
                </div>

                <!-- table des ingrédients -->
                <div class="col-md-6">
                    <table  class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Ingrédient</td>
                                <td>Quantité</td> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ingredients as $ingredient) { ?>
                                <tr>
                                    <td><?= $ingredient['IngredientName'] ?></td>
                                    <td><?= $ingredient['ContainsQuantity'] ?></td> 
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>


                <!-- Preparation de la recette -->
                <div class="col-md-6">
                    <div class="page-header">
                        <h3 class="text-center">Préparation de la recette</h3>
                    </div>
                    <p><?= $recipe['RecipePreparation']; ?></p>
                </div>

                <div class="col-md-12">
                    <p class="col-sm-2">
                        Auteur : 
                        <?php
                        if (!$recipe['idUser']) {
                            echo 'Utilisateur supprimé';
                        } else {
                            echo get_user_pseudo($recipe['idUser']);
                        }
                        ?>
                    </p>
                    <p class="col-sm-2">
                        Origine : 
                        <?= $recipe['RecipeOrigin']; ?>
                    </p>
                    <p class="col-sm-3">
                        Type de plat :
                        <?= $recipe['TypeName'] ?>
                    </p>

                    <div class="col-sm-5">
                        <?php
                        if ($connected) {
                            if (($isAdmin) OR ( check_owner_recipe($_SESSION['idUser'], $idRecipe))) {
                                ?>
                                <a class="btn btn-primary" href="#ConfirmDeleteRecipe" data-toggle="modal"><span class="glyphicon glyphicon-trash"></span> Supprimer</a>
                                <a class="btn btn-primary" href="editerrecette.php?idRecipe=<?= $idRecipe ?>">
                                    <span class="glyphicon glyphicon-pencil"></span> 
                                    Modifier
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div> 
            </div>
            <!-- COMMENTAIRES -->
            <div class="container contenu">
                <!-- Commentaires -->
                <div id="comments" class="comments col-md-10 col-md-offset-1">
                    <div class="page-header">
                        <h2 class="text-center">Commentaires</h2>
                    </div>
                    <?php if ($connected) { ?>

                        <!-- formulaire d'ajout de commentaire -->
                        <form class="form col-md-12 center-block" action="#" method="post">
                            <div class="form-group col-md-7">
                                <textarea maxlength="1000" class="form-control" id="UserComment" name="UserComment" placeholder="Votre commentaire ici" required=""></textarea>
                            </div>   

                            <div class="form-group col-md-2">
                                <input id="UserNote" name="UserNote" type="number" placeholder="Noter" class="form-control" min="1" max="5">
                            </div>
                            <div class="form-group col-md-3">
                                <button class="btn btn-primary btn-block" type="submit" name="SubmitComment" id="SubmitComment" >Commenter</button>
                            </div>
                        </form>
                    <?php } ?>

                    <?php if (empty($comments)) { ?>
                        <div class="col-md-12 breadcrumb">
                            <p class="text-center">Ancuns commentaires</p>
                        </div>
                    <?php } ?>

                    <!-- Affiche tous les commentaire -->    
                    <?php foreach ($comments as $comment) { ?>
                        <div class="col-md-12 breadcrumb">
                            <div class="col-md-4">
                                <p>Posté par 
                                    <b>
                                        <?php
                                        if (!$comment['idUser']) { //Test si l'id est false -> 0
                                            echo 'Utilisateur supprimé';
                                        } else {
                                            echo get_user_pseudo($comment['idUser']); //recupere le pseudo de l'utilisateur grace à son id
                                        }
                                        ?>
                                    </b>
                                </p>
                                <p>Ajouté le 
                                    <?= $comment['CommentDate'] //affiche la date d'ajout du commentaire' ?>
                                </p>
                                <?php
                                if ($connected) {
                                    if (($isAdmin) OR ( check_owner_comment($_SESSION['idUser'], $comment['idComment']))) {
                                        ?>
                                        <a href="#ConfirmDeleteComment<?= $comment['idComment'] ?>" data-toggle="modal">Supprimer</a>
                                        <?php
                                    }
                                }
                                ?>

                            </div>
                            <div class="col-md-8">
                                <p>
                                    <?= $comment['CommentText'] ?>
                                </p>
                            </div>
                        </div>
                        <!-- MODAL DE SUPRESSION DE COMMENTAIRE -->
                        <div class="modal fade" id="ConfirmDeleteComment<?= $comment['idComment'] ?>" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4>
                                            Etes-vous de sur de vouloir supprimer cette recette ?
                                        </h4>
                                    </div> 
                                    <div class="modal-body">
                                        <a class="btn btn-default letf" data-dismiss="modal">Annuler</a>
                                        <a class="btn btn-primary right" href="supprimercommentaire.php?idComment=<?= $comment['idComment'] ?>&idRecipe=<?= $idRecipe ?>" >
                                            <span class="glyphicon glyphicon-trash"></span> 
                                            Supprimer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>


                </div>

            </div>
            <?php
            if ($connected) {
                if (($isAdmin) OR ( check_owner_recipe($_SESSION['idUser'], $idRecipe))) {
                    ?>
                    <!-- MODAL DE SUPRESSION DE RECETTE -->
                    <div class="modal fade" id="ConfirmDeleteRecipe" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>
                                        Etes-vous de sur de vouloir supprimer cette recette ?
                                    </h4>
                                </div> 
                                <div class="modal-body">
                                    <a class="btn btn-default letf" data-dismiss="modal">Annuler</a>
                                    <a class="btn btn-primary right" href="supprimerrecette.php?idRecipe=<?= $idRecipe ?>">
                                        <span class="glyphicon glyphicon-trash"></span> 
                                        Supprimer
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>



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
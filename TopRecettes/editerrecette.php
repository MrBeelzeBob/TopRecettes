<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('script/php/function.php');

//test si un utilisateur est connecté
if (!isset($_SESSION['idUser'])) {
    header('Location: ./');
    exit();
} //définit l'etape d'etition de la recette



$ingredients = ingredients_associate();
$RecipeTypes = recipe_types_associate();


if (isset($_POST['EditRecipe'])) {
    try {
        if ((isset($_POST['EditTitle'])) AND ( isset($_POST['EditType'])) AND ( isset($_POST['EditNbIngredient'])) AND (!empty($_POST['EditTitle'])) AND (!empty($_POST['EditType'])) AND (!empty($_POST['EditNbIngredient']))) {
            
        } else {
            throw new Exception('Merci de remplir le formulaire correctement.');
        }
    } catch (Exception $ex) {
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
    }
}
?>

<!doctype html>
<html lang="fr">
    <head>

        <meta charset="utf-8">
        <title>Editer un recette</title>
        <link href="script/css/bootstrap.min.css" rel="stylesheet">
        <link href="script/css/style.css" rel="stylesheet">

    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top">
            <?php include "liens_menu.php"; ?> 
        </nav>
        <header class="container page-header">
            <h1>TopRecettes <small>Editer une recette</small></h1>
        </header>

        <section>
            <div class="container contenu">

                <div class="modal-header col-sm-6 col-sm-offset-3">
                    <h1 class="text-center">Editer une recette</h1>
                </div>
                <div class="modal-body col-sm-6 col-sm-offset-3">

                    <!-- etape 1 -->

                    <form class="form col-md-12 center-block" action="#" method="post">

                        <div class="form-group">
                            <label class="control-label" for="EditTitle">Titre de la recette</label>
                            <input id="EditTitle" name="EditTitle" type="text" placeholder="Titre de la recette" class="form-control" required="">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="EditType">Type de plat</label>
                            <?php echo Select('EditType', $RecipeTypes, NULL, TRUE); ?>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="EditNbIngredient">Nombre d'ingrédients nécessaire</label>
                            <input id="EditNbIngredient" name="EditNbIngredient" type="number" placeholder="Nombre d'ingrédients nécessaire" class="form-control" min="0" max="20" required="">
                        </div>


                        <div class="form-group col-md-6">
                            <button class="btn btn-primary btn-block" type="reset" >Annuler</button>
                        </div>
                        <div class="form-group col-md-6">
                            <button class="btn btn-primary btn-block" type="submit" name="EditRecipeStep1" id="btn-submit" >Suivant</button>
                        </div>
                        <?php echo DataList('EditListIngredient', $ingredients, NULL); ?>
                    </form>
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
        <script src="script/js/custom.js"></script>
        <script>
            $(document).ready(function() {
                $("#EditNbIngredient").change(function() {
                    create_select_ingredient($("#EditNbIngredient").val());
                }
                );
            });
        </script>
    </body>
</html>

<?php
//var_dump_pre($ingredients);
?>
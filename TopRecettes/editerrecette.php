<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('script/php/function.php');

//test si un utilisateur est connecté
if (!isset($_SESSION['idUser'])) {
    header('Location: ./');
    exit();
}

//test si l'edition d'une recette est en cours
if ((!isset($_SESSION['EditRecipe']['step'])) AND (empty($_SESSION['EditRecipe']['step']))) {
    $EditRecipe["step"] = 1; //définit l'etape d'édition de la recette a 1
    $_SESSION['EditRecipe'] = $EditRecipe;
}


$ingredients = ingredients_associate();
$RecipeTypes = recipe_types_associate();

//test la réception de l'etape 1
if (isset($_POST['EditRecipeStep1'])) {
    try {
        //Test les valeurs dans le formulaire
        if ((isset($_POST['EditRecipeTitle'])) AND ( isset($_POST['EditRecipeType'])) AND ( isset($_POST['EditRecipeNbIngredient'])) AND (!empty($_POST['EditRecipeTitle'])) AND (!empty($_POST['EditRecipeType'])) AND (!empty($_POST['EditRecipeNbIngredient']))) {

            // RECUPERE LES VALEURS DU FORMULAIRE DE L'ETAPE 1 POUR LES AJOUTER DANS UN TABLEAU DANS LA SESSION
            $EditRecipe_step1['step'] = 2;
            $EditRecipe_step1['RecipeTitle'] = $_POST['EditRecipeTitle']; //recupere le titre
            $EditRecipe_step1['RecipeType'] = $_POST['EditRecipeType']; //recupere le type
            $EditRecipe_step1['RecipeNbIngredient'] = $_POST['EditRecipeNbIngredient']; //recupere le nombre d'ingredient
            $EditRecipe_step1['RecipeOrigin'] = $_POST['EditRecipeOrigin']; //recupere le nombre d'ingredient
            $EditRecipe_step1['RecipeImage'] = $_FILES['EditRecipeImage']; //recupere le nombre d'ingredient
            $_SESSION['EditRecipe'] = array_merge($_SESSION['EditRecipe'], $EditRecipe_step1); //ajoute les valeurs dans la session sans effacer les anciennes valeurs
        } else {
            throw new Exception('Merci de remplir le formulaire correctement.');
        }
    } catch (Exception $ex) {
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
    }
}

//test la réception de l'etape 2
if (isset($_POST['EditRecipeStep2'])) {
    try {
        $nbIngredients = $_SESSION['EditRecipe']['RecipeNbIngredient'];
        for ($i = 1; $i <= $nbIngredients; $i++) {
            if ((isset($_POST['EditRecipeIngredient' . $i])) AND (isset($_POST['EditRecipeQuantity' . $i])) AND (!empty($_POST['EditRecipeIngredient' . $i])) AND (!empty($_POST['EditRecipeQuantity' . $i]))) {

                // RECUPERE LES VALEURS DU FORMULAIRE DE L'ETAPE 2 POUR LES AJOUTER DANS UN TABLEAU DANS LA SESSION
                $EditRecipe_Preparation['RecipePreparation'] = $_POST['EditRecipePreparation']; //recupere la preparation
                $_SESSION['EditRecipe'] = array_merge($_SESSION['EditRecipe'], $EditRecipe_Preparation); //ajoute la préparation dans le tableau en session
                $EditRecipe_Ingredients["IngredientName" . $i] = $_POST['EditRecipeIngredient' . $i]; //recupere l'ingredient
                $EditRecipe_Ingredients["IngredientQuantity" . $i] = $_POST['EditRecipeQuantity' . $i]; //recupere la quantité
                $_SESSION['EditRecipe']['Ingredients'] = $EditRecipe_Ingredients; //ajoute les ingrédients dans le tablean en session
            }
        }

        //test si une image est envoyée
        if (!empty($_SESSION['EditRecipe']['RecipeImage']['name'])) {
            $File_Path = upload($_SESSION['EditRecipe']['RecipeImage']); //Upload l'image dans un dossier du serveur et récupère le dossier ou l'image à été uploadé
            var_dump_pre($File_Path);
            
            //add_recipe($_SESSION['EditRecipe'], $_SESSION['idUser']);   
        }
    } catch (Exception $ex) {
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
    }
}

//test si l'utilisateur veut revenir à l'etape 1 lorsqu'il est dans l'etape 2
if (isset($_POST['EditRecipeBack'])) {
    $_SESSION['EditRecipe']['step'] = 1;
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
<?php
if ($_SESSION['EditRecipe']["step"] == 1) {
    include "editerrecette_etape1.php";
}

if ($_SESSION['EditRecipe']["step"] == 2) {
    include "editerrecette_etape2.php";
}
?>
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
    </body>
</html>

<?php
var_dump_pre($_SESSION);
?>
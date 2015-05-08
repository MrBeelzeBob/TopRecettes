<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('script/php/function.php');

//test si un utilisateur est connecté
if (isset($_SESSION['idUser'])) {
    $idUser = $_SESSION['idUser'];

    try {
        //MODIFICATRION D'UNE RECETTE
        if ((isset($_GET['idRecipe'])) AND (!empty($_GET['idRecipe']))) {
            $_SESSION['EditRecipe']['Edit'] = 'update'; // Définit pour reconnaitre qu'il y a une modification
            $idRecipe = $_GET['idRecipe'];
            if ((CheckAdmin($idUser) OR (check_owner_recipe($idUser, $idRecipe)))) {
                $recipe = get_recipe($idRecipe); //Recupere les infos de la recette
                if (!$recipe) {
                    throw new Exception('Cette recette n\'existe pas.');
                }
                $nbIngredients = count_ingredient_recipe($idRecipe); //Recupere le nombre d'ingrédient nécessaire à la réalisation de la recette
                $_SESSION['EditRecipe'] = array_merge($_SESSION['EditRecipe'], $recipe, $nbIngredients); // Envoie tous dans la session
            } else {
                throw new Exception('Vous devez être administrateur ou l\'auteur de la recette pour pouvoir la modifier');
            }
        }
    } catch (Exception $ex) {
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
    }

    if (!isset($_SESSION['EditRecipe']['Edit'])) {
        $_SESSION['EditRecipe']['Edit'] = 'add'; // Définit pour reconnaitre qu'il y a un ajout
    }


    //test si l'edition d'une recette est en cours
    if ((!isset($_SESSION['EditRecipe']['step'])) AND (empty($_SESSION['EditRecipe']['step']))) {
        $EditRecipe["step"] = 1; //définit l'etape d'édition de la recette a 1
        $_SESSION['EditRecipe'] = array_merge($_SESSION['EditRecipe'], $EditRecipe);
    }


//test la réception de l'ETAPE 1
    if (isset($_POST['EditRecipeStep1'])) {
        try {
            //Test les valeurs dans le formulaire
            if ((isset($_POST['EditRecipeTitle'])) AND ( isset($_POST['EditRecipeType'])) AND ( isset($_POST['EditRecipeNbIngredient'])) AND (!empty($_POST['EditRecipeTitle'])) AND (!empty($_POST['EditRecipeType'])) AND (!empty($_POST['EditRecipeNbIngredient']))) {

                // RECUPERE LES VALEURS DU FORMULAIRE DE L'ETAPE 1 POUR LES AJOUTER DANS UN TABLEAU DANS LA SESSION
                $EditRecipe_step1['step'] = 2;
                $EditRecipe_step1['RecipeTitle'] = $_POST['EditRecipeTitle']; //recupere le titre
                $EditRecipe_step1['idType'] = $_POST['EditRecipeType']; //recupere le type
                $EditRecipe_step1['RecipeNbIngredient'] = $_POST['EditRecipeNbIngredient']; //recupere le nombre d'ingredient
                $EditRecipe_step1['RecipeOrigin'] = $_POST['EditRecipeOrigin']; //recupere le nombre d'ingredient
                $_SESSION['EditRecipe'] = array_merge($_SESSION['EditRecipe'], $EditRecipe_step1); //ajoute les valeurs dans la session sans effacer les anciennes valeurs
            } else {
                throw new Exception('Merci de remplir le formulaire correctement.');
            }
        } catch (Exception $ex) {
            ShowError('Une erreur est survenue : ' . $ex->getMessage());
        }
    } // end if etape 1
    //
//test la réception de l'ETAPE 2
    if (isset($_POST['EditRecipeStep2'])) {
        try {
            $nbIngredients = $_SESSION['EditRecipe']['RecipeNbIngredient'];
            $j = 1;
            // RECUPERE LES VALEURS DU FORMULAIRE DE L'ETAPE 2 
            for ($i = 1; $i <= $nbIngredients; $i++) { //Permet de tester si les input des ingrédients sont vide
                if ((isset($_POST['EditRecipeIngredient' . $i])) AND (isset($_POST['EditRecipeQuantity' . $i])) AND (!empty($_POST['EditRecipeIngredient' . $i])) AND (!empty($_POST['EditRecipeQuantity' . $i]))) {
                    $EditRecipe_Ingredients[$j]["IngredientName"] = $_POST['EditRecipeIngredient' . $i]; //recupere l'ingredient (ajouté dans un tableau)
                    $EditRecipe_Ingredients[$j]["IngredientQuantity"] = $_POST['EditRecipeQuantity' . $i]; //recupere la quantité (ajouté dans un tableau)
                    $EditRecipe_Ingredients[$j]["IngredientId"] = checkExist_ingredient($_POST['EditRecipeIngredient' . $i]); //recupere l'id de l'ingredient pour teste ensuite si il existe
                    if (!$EditRecipe_Ingredients[$j]["IngredientId"]) {//check si l'ingredient existe pas'
                        $idNewIngredient = add_ingredient($_POST['EditRecipeIngredient' . $i]); //Ajoute l'ingredient dans la base si il n'existe pas et recupere l'id de l'ingredient ajouté
                        $EditRecipe_Ingredients[$j]["IngredientId"] = $idNewIngredient;
                    } //end if
                    $j++; //index du tableau des ingredient, s'incrémente seuelemtn si l'ingrédient est définit
                } //end if 
            }// end for
            //Test si la preparation est vide
            if ((isset($_POST['EditRecipePreparation'])) AND (!empty($_POST['EditRecipePreparation']))) {
                $EditRecipe_step2['RecipePreparation'] = $_POST['EditRecipePreparation']; //recupere la preparation
                $EditRecipe_step2['RecipeImage_New'] = $_FILES['EditRecipeImage'];
                $TableRecipe_Infos = array_merge($_SESSION['EditRecipe'], $EditRecipe_step2); //Recupere la preparation
            } else {
                throw new Exception('Merci de remplir la préparation de la recette.');
            }




            if ($_SESSION['EditRecipe']['Edit'] == 'add') {//AJOUTE LA NOUVELLE RECETTE + retourne l'id de la recette ajoutée
                $idNewRecipe = add_recipe($TableRecipe_Infos, $_SESSION['idUser']); //Ajoute la recette avec une image par défaut
                for ($i = 1; $i <= sizeof($EditRecipe_Ingredients); $i++) {
                    $idIngredient = $EditRecipe_Ingredients[$i]['IngredientId'];
                    $IngredientQuantity = $EditRecipe_Ingredients[$i]['IngredientQuantity'];
                    add_contains($idIngredient, $IngredientQuantity, $idNewRecipe);
                }
                header('Location: recette.php?id=' . $idNewRecipe);
                $_SESSION['EditRecipe'] = NULL; //vide la variable d'etition dans la session 
                exit();
            }//end add
            if ($_SESSION['EditRecipe']['Edit'] == 'update') {//MODIFICATION DE LA RECETTE
                edit_recipe($_SESSION['EditRecipe']['idRecipe'], $TableRecipe_Infos); // MODIFIE LA RECETTE
                delete_contains_recipe($_SESSION['EditRecipe']['idRecipe']); //Supprime tous les ingrédients associé à la recette en cours de mdification
                //Ajoute les nouveaux ingredients et quantités dans la base
                for ($i = 1; $i <= sizeof($EditRecipe_Ingredients); $i++) {
                    $idIngredient = $EditRecipe_Ingredients[$i]['IngredientId'];
                    $IngredientQuantity = $EditRecipe_Ingredients[$i]['IngredientQuantity'];
                    add_contains($idIngredient, $IngredientQuantity, $_SESSION['EditRecipe']['idRecipe']);
                }
                $_SESSION['EditRecipe'] = NULL; //vide la variable d'etition dans la session 
                header('Location: recette.php?id=' . $_SESSION['EditRecipe']['idRecipe']);
                exit();
            }//end edit
            $_SESSION['EditRecipe'] = NULL; //vide la variable d'etition dans la session 
        } catch (Exception $ex) {
            ShowError('Une erreur est survenue : ' . $ex->getMessage());
        }
    }// end if etape 2
//test si l'utilisateur veut revenir à l'etape 1 lorsqu'il est dans l'etape 2
    if (isset($_POST['EditRecipeBack'])) {
        $_SESSION['EditRecipe']['step'] = 1;
    }
    if (isset($_POST['EditReset'])) {
        header('Location: ./');
        $_SESSION['EditRecipe'] = NULL; //vide la variable d'etition dans la session 
        exit();
    }
} else {
    header('Location: ./');
    exit();
}


if ($_SESSION['EditRecipe']['Edit'] == 'add') {
    $edit = 'Ajouter';
}
if ($_SESSION['EditRecipe']['Edit'] == 'update') {
    $edit = 'Modifier';
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
            <h1>TopRecettes <small><?= $edit ?> une recette</small></h1>
        </header>

        <section>
            <div class="container contenu">

                <div class="modal-header col-sm-6 col-sm-offset-3">
                    <h1 class="text-center"><?= $edit ?> une recette</h1>
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
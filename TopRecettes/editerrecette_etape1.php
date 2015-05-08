<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('script/php/function.php');

$RecipeTitle = NULL;
$RecipeType = NULL;
$RecipeNbIngredient = NULL;
$RecipeOrigin = NULL;


//Test si l'info est dans la session pour pouvoir l'afficher dans le formulaire
if (isset($_SESSION['EditRecipe']['RecipeTitle'])) {
    $RecipeTitle = $_SESSION['EditRecipe']['RecipeTitle']; //recupere l'info
}
//Test si l'info est dans la session pour pouvoir l'afficher dans le formulaire
if (isset($_SESSION['EditRecipe']['idType'])) {
    $RecipeType = $_SESSION['EditRecipe']['idType']; //recupere l'info
}
//Test si l'info est dans la session pour pouvoir l'afficher dans le formulaire
if (isset($_SESSION['EditRecipe']['RecipeTitle'])) {
    $RecipeNbIngredient = $_SESSION['EditRecipe']['RecipeNbIngredient']; //recupere l'info
}
//Test si l'info est dans la session pour pouvoir l'afficher dans le formulaire
if (isset($_SESSION['EditRecipe']['RecipeOrigin'])) {
    $RecipeOrigin = $_SESSION['EditRecipe']['RecipeOrigin']; //recupere l'info
}



$RecipeTypes = recipe_types_associate();
?>

<!doctype html>
<html lang="fr">
    <head>

        <meta charset="utf-8">

    </head>
    <body>

        <!-- etape 1 du formulaire d'edition de recette-->
        <form class = "form col-md-12 center-block" action = "editerrecette.php" method = "post" >

            <div class="form-group">
                <label class="control-label" for="EditRecipeTitle">Titre de la recette</label>
                <input id="EditRecipeTitle" name="EditRecipeTitle" type="text" placeholder="Titre de la recette" class="form-control" required="" value="<?= $RecipeTitle ?>">
            </div>

            <div class="form-group">
                <label class="control-label" for="EditRecipeType">Type de plat</label>
                <?php echo Select('EditRecipeType', $RecipeTypes, $RecipeType, TRUE); ?>
            </div>
            <div class="form-group">
                <label class="control-label" for="EditRecipeNbIngredient">Nombre d'ingrédients nécessaire</label>
                <input id="EditRecipeNbIngredient" name="EditRecipeNbIngredient" type="number" placeholder="Nombre d'ingrédients nécessaire" value="<?= $RecipeNbIngredient ?>" class="form-control" min="0" max="20" required="">
            </div>

            <div class="form-group">
                <label class="control-label" for="EditRecipeOrigin">Origine de la recette</label>
                <input id="EditRecipeOrigin" name="EditRecipeOrigin" type="text" placeholder="Origine de la recette" value="<?= $RecipeOrigin ?>" class="form-control" >
            </div>

            <div class="form-group col-md-6">
                <button class="btn btn-primary btn-block" type="reset" name="EditReset">Annuler</button>
            </div>
            <div class="form-group col-md-6">
                <button class="btn btn-primary btn-block" type="submit" name="EditRecipeStep1" id="btn-submit" >Suivant</button>
            </div>
        </form>
    </body>
</html>
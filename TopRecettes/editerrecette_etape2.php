<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('script/php/function.php');

$nbIngredients = $_SESSION['EditRecipe']["RecipeNbIngredient"];

var_dump_pre($nbIngredients);
$ingredients = ingredients_associate();
?>

<!doctype html>


<!-- etape 1 du formulaire d'edition de recette-->
<form class = "form col-md-12 center-block" action="editerrecette.php" method="post" enctype="multipart/form-data">

    <?php for ($i = 1; $i <= $nbIngredients; $i++) { ?>
        <div class="form-group">
            <label class="control-label" for="EditIngredient<?= $i ?>">Ingredient et quantité - n° <?= $i ?></label>
            <input id="EditIngredient<?= $i ?>" name="EditRecipeIngredient<?= $i ?>" type="text" placeholder="Ingredient" class="form-control"  list="EditListIngredient"> 
            <input id="EditQuantity<?= $i ?>" name="EditRecipeQuantity<?= $i ?>" type="text" placeholder="Quantité" class="form-control" > 
        </div>
    <?php } ?>

    <div class="form-group">
        <label class="control-label" for="EditRecipePreparation">Préparation de la recette</label>
        <textarea maxlength="1000" class="form-control" id="UserComment" name="EditRecipePreparation" id="EditRecipePreparation." placeholder="Préparation de la recette" ></textarea>
    </div>

    <div class="form-group">
        <label class="control-label" for="EditRecipeImage">Image représentant la recette</label>
        <input id="EditRecipeImage" name="EditRecipeImage" class="input-file" type="file" accept="image/*" >
    </div>

    <div class="form-group col-md-6">
        <button class="btn btn-primary btn-block" type="submit" name="EditRecipeBack">Précédent</button>
    </div>
    <div class="form-group col-md-6">
        <button class="btn btn-primary btn-block" type="submit" name="EditRecipeStep2" id="btn-submit" >Terminer</button>
    </div>
    <?php echo DataList('EditListIngredient', $ingredients); ?>
</form>

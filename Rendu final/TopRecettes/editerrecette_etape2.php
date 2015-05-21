<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015

Edition d'une recette etape 2 (formulaire)- editerrecette_etape2.php
-->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['idUser'])) { //test si l'utilisateur est connecté
    header('location: ./');
    exit();
}

require_once('script/php/function.php');

$nbIngredients = $_SESSION['EditRecipe']["RecipeNbIngredient"]; //Récupère le nombre d'ingrédient 

$TableIngredients = ingredients_associate(); //recupere tous les ingrédients de la base
//Test si il ya modification
if ($_SESSION['EditRecipe']['Edit'] == 'update') {
    //Recupere les ingrédient associé à la recette en cours de modification
    $ingredients = get_ingredients_recipe($_SESSION['EditRecipe']['idRecipe']);
    $RecipePreparation = $_SESSION['EditRecipe']['RecipePreparation'];
} else {
    $RecipePreparation = NULL;
}
?>

<!doctype html>


<!-- etape 1 du formulaire d'edition de recette-->
<form class = "form col-md-12 center-block" action="editerrecette.php" method="post" enctype="multipart/form-data">
<p>* Un ingrédient sans quantité ne sera pas ajouté et inversement *</p>
    <?php
    for ($i = 1; $i <= $nbIngredients; $i++) {
        if (!isset($ingredients[$i - 1])) {
            $ingredients[$i - 1]['IngredientName'] = NULL;
            $ingredients[$i - 1]['ContainsQuantity'] = NULL;
        }
        ?>
    
        <div class="form-group">
           
            <label class="control-label" for="EditIngredient<?= $i ?>">Ingredient et quantité - n° <?= $i ?></label>
            <input id="EditIngredient<?= $i ?>" name="EditRecipeIngredient<?= $i ?>" type="text" value="<?= $ingredients[$i - 1]['IngredientName'] ?>" placeholder="Ingredient" class="form-control"  list="EditListIngredient"> 
            <input id="EditQuantity<?= $i ?>" name="EditRecipeQuantity<?= $i ?>" type="text" value="<?= $ingredients[$i - 1]['ContainsQuantity'] ?>" placeholder="Quantité" class="form-control" > 
        </div>
    <?php } ?>

    <div class="form-group">
        <label class="control-label" for="EditRecipePreparation">Préparation de la recette *</label>
        <textarea maxlength="5000" class="form-control" id="EditRecipePreparation" name="EditRecipePreparation" id="EditRecipePreparation."  placeholder="Préparation de la recette" ><?= $RecipePreparation ?></textarea>
    </div>

    <div class="form-group">
        <label class="control-label" for="EditRecipeImage">Image représentant la recette</label>
        <input id="EditRecipeImage" name="EditRecipeImage" class="input-file" type="file" accept="image/*" >
    </div>

    <div class="form-group col-md-4">
        <button class="btn btn-primary btn-block" type="submit" name="EditRecipeBack">Précédent</button>
    </div>

    <div class="form-group col-md-4">
        <button class="btn btn-primary btn-block" type="submit" name="EditReset">Annuler</button>
    </div>

    <div class="form-group col-md-4">
        <button class="btn btn-primary btn-block" type="submit" name="EditRecipeStep2" id="btn-submit" >Terminer</button>
    </div>
    <?php echo DataList('EditListIngredient', $TableIngredients); ?>
</form>

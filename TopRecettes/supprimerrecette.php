<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015
-->
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('script/php/function.php');

if ((isset($_GET['idRecipe'])) AND (!empty($_GET['idRecipe']))) {
    //test si l'utilisateur est connecter
    if (isset($_SESSION['idUser'])) {
        $idRecipe = $_GET['idRecipe'];
        if ((CheckAdmin($_SESSION['idUser'])) OR (check_owner_recipe($_SESSION['idUser'], $_GET['idRecipe']))) {//test si admin ou proprietaire du commentaire
            unlink(get_recipe_image($idRecipe));
            delete_recipe($idRecipe); //supprime la recette
            delete_contains_recipe($idRecipe); //Supprimer les ingrédient associés à la recette;
            delete_comment_recipe($idRecipe); //Supprime les commentaire, les notes attribuer à la recette
            header('Location: recettes.php');
            $exit();
        } else {
            header('Location: recette.phpid=' . $_GET['idRecipe']);
            exit();
        }
    } else {
        header('Location: recette.php?id=' . $_GET['idRecipe']);
        exit();
    }
} else {
    header('Location: recettes.php');
    exit();
}
header('Location: recettes.php');
exit();
?>

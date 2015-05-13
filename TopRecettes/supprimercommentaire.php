<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015

Supprime un commentaire (pas d'interface) - supprimercommentaire.php
-->
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('script/php/function.php');

if ((isset($_GET['idComment'])) AND ( !empty($_GET['idComment'])) AND ( isset($_GET['idRecipe'])) AND ( !empty($_GET['idRecipe']))) {
    //test si l'utilisateur est connecter
    if (isset($_SESSION['idUser'])) {
        if ((CheckAdmin($_SESSION['idUser'])) OR (check_owner_comment($_SESSION['idUser'], $_GET['idComment']))) {//test si admin ou proprietaire du commentaire
            delete_comment($_GET['idComment']); //supprime le commentaire
            header('Location: recette.php?id=' . $_GET['idRecipe'] . "#comments");
            exit();
        } else {
            header('Location: recette.php?id=' . $_GET['idRecipe'] . "#comments");
            exit();
        }
    } else {
        header('Location: recette.php?id=' . $_GET['idRecipe'] . "#comments");
        exit();
    }
} else {
    header('Location: recettes.php');
    exit();
}
header('Location: recettes.php');
exit();
?>

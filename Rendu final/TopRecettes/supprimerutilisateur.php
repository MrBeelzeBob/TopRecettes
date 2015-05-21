<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015

Supprime un utilisateur (pas d'interface) - supprimerutilisateur.php
-->
<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('script/php/function.php');

if ((isset($_GET['idUser'])) AND (!empty($_GET['idUser']))) {
    $idUser = $_GET['idUser'];
    //test si l'utilisateur est connecter
    if (isset($_SESSION['idUser'])) {
        if (CheckAdmin($_SESSION['idUser'])) {//test si l'utilisateur est un admin 
            delete_user($idUser); //Supprime l'utilisateur
            delete_link_user_recipes($idUser); //Efface le lien entre l'utilisateur et ses recettes
            delete_user_comments($idUser); //supprime les commentaire posté par l'utilisateur
            header('Location: utilisateurs.php');
            exit();
        } else {
            header('Location: utilisateurs.php');
            exit();
        }
    } else {
        header('Location: ./');
        exit();
    }
} else {
    header('Location: ./');
    exit();
}
header('Location: ./');
exit();
?>

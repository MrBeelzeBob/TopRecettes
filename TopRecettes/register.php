<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('script/php/function.php');

//test si un utilisateur est connecté
if ((isset($_SESSION['idUser'])) AND ( isset($_SESSION['UserPseudo']))) {
    header('Location: ./');
    exit();
}

$erreur = false;

if (isset($_POST['Register'])) {
    if ((isset($_POST['RegisterEmail'])) AND ( isset($_POST['RegisterPseudo']))
            AND ( isset($_POST['RegisterPassword'])) AND ( isset($_POST['RegisterConfirm']))) {
        //

        $UserPseudo = $_POST['RegisterPseudo'];
        $UserEmail = $_POST['RegisterEmail'];
        $UserPassword = md5($_POST['RegisterPassword']);
        $UserConfirm = md5($_POST['RegisterConfirm']);

        //check email
        $EmailValid = preg_match('^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$^', $UserEmail);
        if ($EmailValid) {

            //check password
            if ($UserPassword == $UserConfirm) {
                $log = register($UserPseudo, $UserEmail, $UserPassword);

                //
                if ($log) {
                    //Connecte le nouveau utilisateur
                    login($UserEmail, $UserPassword);
                    header('Location: ./');
                } else {
                    $erreur = true;
                    $Message = 'Le Pseudo ou l\'Email existe déjà.';
                }
            } else {
                $erreur = true;
                $Message = 'Mot de passe mal confirmé';
            }
        }
    }
}
?>

<!doctype html>
<html lang="fr">
    <head>

        <meta charset="utf-8">
        <title>Inscription - TopRecettes</title>
        <link href="script/css/bootstrap.min.css" rel="stylesheet">
        <link href="script/css/style.css" rel="stylesheet">

    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top">
            <?php include "liens_menu.php"; ?> 
        </nav>
        <header class="container page-header">
            <h1>TopRecettes <small>Inscription</small></h1>
        </header>

        <section>
            <div class="container contenu">
                <!-- message d'erreur -->
                <?php
                if ($erreur) {
                    echo MessageErreur($Message);
                }
                ?>


                <div class="modal-header col-sm-6 col-sm-offset-3">
                    <h1 class="text-center">Inscription</h1>
                </div>
                <div class="modal-body col-sm-6 col-sm-offset-3">

                    <form class="form col-md-12 center-block" action="#" method="post">

                            <div class="form-group">
                                <input type="text" name="RegisterPseudo" id="RegisterPseudo" class="form-control input-lg" placeholder="Pseudo" required="">
                            </div>

                            <div class="form-group">
                                <input type="email" pattern="^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$"  name="RegisterEmail" id="RegisterEmail" class="form-control input-lg" placeholder="Email" required="">
                            </div>

                            <div class="form-group">
                                <input type="password" name="RegisterPassword" id="RegisterPassword" class="form-control input-lg" placeholder="Mot de passe" required="">
                            </div>

                            <div class="form-group">
                                <input type="password" name="RegisterConfirm" id="RegisterConfirm" class="form-control input-lg" placeholder="Confirmation du mot de passe" required="">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary btn-lg btn-block" type="submit" name="Register" id="Register" >Inscription</button>
                                <p>Déjà inscris clique <a href="login.php">ici</a><p>
                            </div>
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
    </body>
</html>
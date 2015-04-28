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

//Connexion
if (isset($_POST['Login'])) {
    if ((isset($_POST['LoginEmail'])) AND ( isset($_POST['LoginPassword']))) {
        $UserEmail = $_POST['LoginEmail'];
        $UserPassword = md5($_POST['LoginPassword']);
        $log = login($UserEmail, $UserPassword);
        if ($log) {
            header('Location: ./');
        } else {
            $erreur = true;
            $Message = 'L\'email ou le mot de passe ne conrrespond pas.';
        }
    }
}
?>

<!doctype html>
<html lang="fr">
    <head>

        <meta charset="utf-8">
        <title>Connexion - TopRecettes</title>
        <link href="script/css/bootstrap.min.css" rel="stylesheet">
        <link href="script/css/style.css" rel="stylesheet">

    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top">
            <?php include "liens_menu.php"; ?> 
        </nav>
        <header class="container page-header">
            <h1>TopRecettes <small>Connexion</small></h1>
        </header>

        <section>
            <div class="container contenu">
                <!-- message d'erreur -->
                <?php
                if ($erreur) {
                    echo MessageErreur($Message);
                }
                ?>

                <!--login modal-->

                <div class="modal-header col-sm-6 col-sm-offset-3">
                    <h1 class="text-center">Connexion</h1>
                </div>
                <div class="modal-body col-sm-6 col-sm-offset-3">

                    <form class="form col-md-12 center-block" action="#" method="post">
                        <div class="form-group">
                            <input type="email" id="LoginEmail" name="LoginEmail" class="form-control input-lg" placeholder="Email" required="">
                        </div>

                        <div class="form-group">
                            <input type="password" id="LoginPassword" name="LoginPassword" class="form-control input-lg" placeholder="Password" >
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary btn-lg btn-block" type="submit" name="Login" id="Login" >Connexion</button>
                            <p>Pas encore inscris clique <a href="register.php">ici</a><p>
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
<!doctype html>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./script/php/function.php');

//test si l'utilisateur est connecté
//test si l'utilisateur est connecté
if ((isset($_SESSION['idUser'])) AND ( isset($_SESSION['UserPseudo']))) {
    $isAdmin = CheckAdmin($_SESSION['idUser']);
    $connected = TRUE;

    if (isset($_POST['EditUser'])) {
        if ((isset($_POST['ActualPassword'])) AND ( isset($_POST['EditNewPwd'])) AND ( isset($_POST['EditNewPwdConfirm']))) {
            echo 'caca';
        }
    }
    //test si admin
    if ((isset($_GET['id'])) AND (!empty($_GET['id']))) {
        if ($isAdmin) {
            $user = get_user($_GET['id']);
        }
    }

    //test si user
    if ($connected) {
        $user = get_user($_SESSION['idUser']);
    }
} else {
    header('Location: ./');
}

var_dump_pre($user);
var_dump_pre($isAdmin);
var_dump_pre($connected);
?>


<html lang="fr">
    <head>

        <meta charset="utf-8">
        <title>Mon Compte </title>      
        <link href="script/css/bootstrap.min.css" rel="stylesheet">

        <link href="script/css/style.css" rel="stylesheet">

    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
<?php include "liens_menu.php"; ?>    
        </nav>
        <header class="container page-header">
            <h1>TopRecettes <small>Mon Compte</small></h1>
        </header>

        <section>
            <div class="container contenu">

                <div class="col-sm-6 col-sm-offset-3">
                    <div class="page-header">
                        <h2>Mes informations</h2>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p><b>Pseudo </b></p>
                        </div>
                        <div class="col-sm-8">
                            <p> <?= $user['UserPseudo'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p><b>Email </b></p>
                        </div>
                        <div class="col-sm-8">
                            <p> <?= $user['UserEmail'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p><b>Type de compte </b></p>
                        </div>
                        <div class="col-sm-8">
                            <p> 
                                <?php
                                if ($user['UserAdmin']) {
                                    echo 'Administrateur';
                                }
                                if (!$user['UserAdmin']) {
                                    echo 'Utilisateur';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p><b>Mot de passe </b></p>
                        </div>
                        <div class="col-sm-8">
                            <p> <a href="javascript:;" onclick="Show_form_edit_pwd();">Modifier le mot de passe</a></p>
                        </div>
                    </div>
                    <br>

                </div>

                <span id="form_edit_pwd">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="page-header">
                            <h2>Modifier le mot de passe</h2>
                        </div>

                        <!-- Formulaire de modification de mot de passe -->
                        <form class="form col-md-12 center-block" action="#" method="post">
                            <div class="form-group">
                                <input type="password" name="ActualPassword" id="ActualPassword" class="form-control" placeholder="Mot de passe actuel" required="">
                            </div>

                            <div class="form-group">
                                <input type="password" name="EditNewPwd" id="EditNewPwd" class="form-control" placeholder="Nouveau mot de passe" required="">
                            </div>

                            <div class="form-group">
                                <input type="password" name="EditNewPwdConfirm" id="EditNewPwdConfirm" class="form-control" placeholder="Confirmation du nouveau mot de passe" required="">
                            </div>

                            <div class="form-group col-md-6">
                                <button class="btn btn-primary btn-block" type="reset" onclick="Hide_form_edit_pwd();">Annuler</button>
                            </div>
                            <div class="form-group col-md-6">
                                <button class="btn btn-primary btn-block" type="submit" name="EditUser" id="EditUser" >Modifier</button>
                            </div>
                        </form>
                    </div>
                </span>
            </div>
        </section>

        <footer class="container">
            <p class="navbar-text">
                Cedric Dos Reis - CFPT 2015 
            </p>
        </footer>

        <script src="script/js/custom.js"></script>
        <script src="script/js/jquery.js"></script>
        <script src="script/js/bootstrap.min.js"></script>

    </body>
</html>
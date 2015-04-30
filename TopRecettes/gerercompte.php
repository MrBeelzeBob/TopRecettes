<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./script/php/function.php');
$Admin_Modif = false;

//test si l'utilisateur est connecté
if ((isset($_SESSION['idUser'])) AND ( isset($_SESSION['UserPseudo']))) {
    $isAdmin = CheckAdmin($_SESSION['idUser']);
    $connected = TRUE;

    if ((isset($_GET['id'])) AND (!empty($_GET['id']))) { //check si id en parametre
        try {
            if ($isAdmin) { //test si admin
                $idUser = $_GET['id'];
                $user = get_user($idUser);
                $Admin_Modif = TRUE; //Autorise la modif d'utilisateur

                if (isset($_POST['AdminEditUser'])) { //Formulaire modif utilisateur
                    //check pseudo et email
                    if ((!empty($_POST['AdminEditPseudo'])) AND (!empty($_POST['AdminEditEmail']))) {
                        $exist = CheckExist_Pseudo_Email($_POST['AdminEditPseudo'], $_POST['AdminEditEmail']);
                        if (!$exist) {
                            if ((!empty($_POST['AdminEditNewPwd'])) AND (!empty($_POST['AdminEditNewPwdConfirm']))) { //check modif password
                                $pwd = md5($_POST['AdminEditNewPwd']);
                                $confirmPwd = md5($_POST['AdminEditNewPwdConfirm']);
                                if ($pwd == $confirmPwd) { //check password identique
                                    edit_user(md5($_POST['AdminEditPseudo']), md5($_POST['AdminEditEmail']), $idUser);  //modifie l'utilisateur
                                    $PasswordChanged = edit_password($idUser, $pwd);
                                    if ($PasswordChanged) {
                                        ShowSuccess('Le mot de passe a été correctement modifié');
                                    }
                                    ShowSuccess('L\'utilisateur a été correctement modifié');
                                } else {
                                    throw new Exception('Mot de passe mal confirmé');
                                }
                            } else {
                                //edit_user($_POST['AdminEditPseudo'], $_POST['AdminEditEmail']);  //modifie uniquement l'utilisateur
                            }
                        } else {
                            throw new Exception('Le Pseudo ou l\'Email existe est déjà utilisé.');
                        }
                    } else {
                        throw new Exception('Merci de remplir le formulaire correctement');
                    }
                }
            } else {
                throw new Exception('Vous devez être administrateur pour modifier cette utilisateur');
            }
        } catch (Exception $ex) {
            ShowError('Une erreur est survenue : ' . $ex->getMessage());
        }
    }

    //test si l'utilisateur est connecté
    if ((!$Admin_Modif) AND($connected)) {
        $idUser = $_SESSION['idUser'];
        $user = get_user($idUser);
    }

    //test si modification de mot de passe
    if (isset($_POST['EditUser'])) {
        if ((isset($_POST['CurrentPassword'])) AND ( isset($_POST['EditNewPwd'])) AND ( isset($_POST['EditNewPwdConfirm']))) {
            //verifie que le nouveau mdp et la confirmation du nouveau mdp sont pareil
            $pwd = md5($_POST['EditNewPwd']);
            $confirmPwd = md5($_POST['EditNewPwdConfirm']);
            if ($pwd == $confirmPwd) {
                //Véréfie le mot de passe actuel
                $PasswordCorrect = check_password($idUser, md5($_POST['CurrentPassword']));
                if ($PasswordCorrect) {
                    $PasswordChanged = edit_password($idUser, $pwd);
                    if ($PasswordChanged) {
                        ShowSuccess('Le mot de passe a été correctement modifié');
                    }
                } else {
                    throw new Exception('Le mot de passe est incorrect.');
                }
            } else {
                throw new Exception('Mot de passe mal confirmé.');
            }
        } else {
            throw new Exception('Merci de remplir le formulaire correctement');
        }
    }
} else {
    header('Location: ./');
    exit();
}


/* var_dump_pre($user);
  var_dump_pre($isAdmin);
  var_dump_pre($connected);
  var_dump_pre($idUser); */
?>

<!doctype html>
<html lang="fr">
    <head>

        <meta charset="utf-8">
        <title>Gestion de compte </title>      
        <link href="script/css/bootstrap.min.css" rel="stylesheet">
        <link href="script/css/style.css" rel="stylesheet">
    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <?php include "liens_menu.php"; ?>    
        </nav>
        <header class="container page-header">
            <h1>TopRecettes <small>Gestion de compte</small></h1>
        </header>

        <section>
            <div class="container contenu">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#infos" data-toggle="tab" aria-expanded="false">Information de l'utilisateur</a></li>
                    <?php if ($Admin_Modif) { ?>
                        <li class=""><a href="#FormEditUser" data-toggle="tab" aria-expanded="false">Modifier l'utilisateur</a></li>
                    <?php } else { ?>
                        <li class=""><a href="#FormEditPwd" data-toggle="tab" aria-expanded="false">Modifier le mot de passe</a></li>
                    <?php } ?>
                </ul>

                <!-- contenu des onglets -->
                <div id="info" class="tab-content">
                    <!-- Onglet d'information -->
                    <div class="tab-pane fade active in" id="infos">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="page-header">
                                <h2>Informations de l'utilisateur</h2>
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
                            <br>
                        </div>
                    </div>
                    <!-- Onglet de modification du mot de passe -->
                    <?php if (!$Admin_Modif) { ?>
                        <div class="tab-pane fade" id="FormEditPwd">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="page-header">
                                    <h2>Modifier le mot de passe</h2>
                                </div>

                                <!-- Formulaire de modification de mot de passe -->
                                <form class="form col-md-12 center-block" action="#" method="post">
                                    <div class="form-group">
                                        <input type="password" name="CurrentPassword" id="CurrentPassword" class="form-control" placeholder="Mot de passe actuel" required="">
                                    </div>

                                    <div id="inputPwd" class="form-group">
                                        <input type="password" name="EditNewPwd" id="EditNewPwd" class="form-control" placeholder="Nouveau mot de passe" required=''>
                                    </div>

                                    <div id="inputPwdConfirm" class="form-group">
                                        <input type="password" name="EditNewPwdConfirm" id="EditNewPwdConfirm" class="form-control" placeholder="Confirmation du nouveau mot de passe" required="">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary btn-block" type="reset" >Annuler</button>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary btn-block" type="submit" name="EditUser" id="btn-submit" >Modifier</button>
                                    </div>


                                </form>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- onglet de modification de l'utilisateur -->
                    <?php if ($Admin_Modif) { ?>
                        <div class="tab-pane fade" id="FormEditUser">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="page-header">
                                    <h2>Modifier 'utilisateur</h2>
                                </div>

                                <!-- Formulaire de modification l'utilisateur -->
                                <form class="form col-md-12 center-block" action="#" method="post">
                                    <div class="form-group">
                                        <input type="text" name="AdminEditPseudo"  class="form-control" placeholder="Nouveau Pseudo"  value="<?= $user['UserPseudo'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <input type="email" pattern="^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$" name="AdminEditEmail"  class="form-control" placeholder="Nouvelle adress Email"  value="<?= $user['UserEmail'] ?>">
                                    </div>

                                    <div id="inputPwd" class="form-group">
                                        <input type="password" name="AdminEditNewPwd" id="EditNewPwd" class="form-control" placeholder="Nouveau mot de passe" >
                                    </div>

                                    <div id="inputPwdConfirm" class="form-group">
                                        <input type="password" name="AdminEditNewPwdConfirm" id="EditNewPwdConfirm" class="form-control" placeholder="Confirmation du nouveau mot de passe" >
                                    </div>

                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary btn-block" type="reset" >Annuler</button>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <button class="btn btn-primary btn-block" type="submit" name="AdminEditUser" id="btn-submit" >Modifier</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } ?>

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
        <script>

        </script>

    </body>
</html>
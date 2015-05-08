<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./script/php/function.php');
require_once ('./script/php/outilsFormulaire.php');
$Admin_Modif = false;

//test si l'utilisateur est connecté
if (isset($_SESSION['idUser'])) {
    $isAdmin = CheckAdmin($_SESSION['idUser']);
    $connected = TRUE;
    $TypeUser = array("0" => "Utilisateur", "1" => "Administrateur");

    if ((isset($_GET['id'])) AND ( !empty($_GET['id']))) { //check si id en parametre
        try {
            if ($isAdmin) { //test si admin
                $idUser = $_GET['id'];
                $user = get_user($idUser); //recupere les information de l'utilisateur dont l'id est en parametre
                $Admin_Modif = TRUE; //Autorise la modif d'utilisateur
                if ($user) {
                    if (isset($_POST['DeleteUser'])) {
                        if (isset($_POST['idUser_toDlete'])) {
                            $idUser_ToDelete = $_POST['idUser_toDlete'];
                            delete_user($idUser_ToDelete);
                            delete_link_user_recipes($idUser);
                            delete_link_user_comments($idUser);
                        } else {
                            throw new Exception('L\'identifiant de l\'utilisateur est manquant.');
                        }
                    }

                    if (isset($_POST['AdminEditUser'])) { //Formulaire de modification de l'utilisateur (pseudo, email , nouveau mot de pass)
                        //check pseudo et email
                        if ((isset($_POST['AdminEditPseudo'])) AND ( isset($_POST['AdminEditEmail'])) AND ( !empty($_POST['AdminEditPseudo'])) AND ( !empty($_POST['AdminEditEmail']))) {
                            $NewPseudo = $_POST['AdminEditPseudo'];
                            $NewEmail = $_POST['AdminEditEmail'];
                            if ($NewPseudo != $user['UserPseudo']) { //test si le pseudo est modifié
                                $existPseudo = CheckExist_Pseudo($NewPseudo);
                                if (!$existPseudo) {//test si le pseudo est existe deja
                                    edit_user($NewPseudo, NULL, $idUser); //modifie le pseudo
                                    ShowSuccess('Le pseudo a été correctement modifié.');
                                } else {
                                    throw new Exception('Le pseudo est déjà utilisé. Aucune modification n\'a été éffectuée,');
                                }
                            }
                            if ($NewEmail != $user['UserEmail']) {//test si l'email est modifié
                                $existEmail = CheckExist_Email($NewEmail);
                                if (!$existEmail) { //test si lemail est existe deja
                                    edit_user(NULL, $NewEmail, $idUser); //modifie l' email
                                    ShowSuccess('L\'email a été correctement modifié.');
                                } else {
                                    throw new Exception('L\'email est déjà utilisé. Aucune modification n\'a été éffectuée');
                                }
                            }
                            if (isset($_POST['AdminEditTypeUser'])) { //test si modification du type d'utilisateur
                                if ($_POST['AdminEditTypeUser'] != $user['UserAdmin']) { //test s'il y a changement du type d'utilisateur
                                    if (($_POST['AdminEditTypeUser'] == 0) OR ( $_POST['AdminEditTypeUser'] == 1)) {
                                        $SetAddmin = set_administrateur($_POST['AdminEditTypeUser'], $idUser);
                                        if ($SetAddmin) {
                                            ShowSuccess('Le type d\'utilisateur à été correctement modifié.');
                                        }
                                    } else {
                                        throw new Exception('Le type d\'utilisateur est incorrect.');
                                    }
                                }
                            }
                        } else {
                            throw new Exception('Merci de remplir le formulaire correctement. Ne modifier pas ce que vous ne voulez pas modifier.');
                        }
                        // test si demande de changer le mot de passe
                        if ((!empty($_POST['AdminEditNewPwd'])) AND ( !empty($_POST['AdminEditNewPwdConfirm']))) { //check l'admin a modifier lepassword (pas obligatoire)
                            $pwd = md5($_POST['AdminEditNewPwd']);
                            $confirmPwd = md5($_POST['AdminEditNewPwdConfirm']);
                            if ($pwd == $confirmPwd) { //check si les password sont identique
                                $PasswordChanged = edit_user_password($idUser, $pwd); //change le mot de asse
                                if ($PasswordChanged) {
                                    ShowSuccess('Le mot de passe à été correctement modifié.');
                                }
                            } else {
                                throw new Exception('Mot de passe mal confirmé.');
                            }
                        }//end check password
                    } //end check modif de l'utilisateur 
                } else {
                    throw new Exception('Cet utilisateur n\'éxiste pas');
                }
                $user = get_user($idUser); //recupere les information de l'utilisateur dont l'id est en parametre
            } else {
                throw new Exception('Vous devez être administrateur pour modifier cette utilisateur');
            }
        } catch (Exception $ex) {
            ShowError('Une erreur est survenue : ' . $ex->getMessage());
        }
    } //end if test id en parametre
    //test si l'utilisateur est connecté
    if ((!$Admin_Modif) AND ( $connected)) {
        $idUser = $_SESSION['idUser'];
        $user = get_user($idUser);
    }

    //test si modification de mot de passe
    if (isset($_POST['EditUser'])) {
        try {
            if ((isset($_POST['CurrentPassword'])) AND ( isset($_POST['EditNewPwd'])) AND ( isset($_POST['EditNewPwdConfirm']))) {
                //verifie que le nouveau mdp et la confirmation du nouveau mdp sont pareil
                $pwd = md5($_POST['EditNewPwd']);
                $confirmPwd = md5($_POST['EditNewPwdConfirm']);
                if ($pwd == $confirmPwd) {
                    //Véréfie le mot de passe actuel
                    $PasswordCorrect = check_password($idUser, md5($_POST['CurrentPassword']));
                    if ($PasswordCorrect) {
                        $PasswordChanged = edit_user_password($idUser, $pwd);
                        if ($PasswordChanged) {
                            ShowSuccess('Le mot de passe a été correctement modifié.');
                        }
                    } else {
                        throw new Exception('Le mot de passe est incorrect.');
                    }
                } else {
                    throw new Exception('Mot de passe mal confirmé.');
                }
            } else {
                throw new Exception('Merci de remplir le formulaire correctement.');
            }
        } catch (Exception $ex) {
            
        }
    }
} else {
    header('Location: ./');
    exit();
}

$isAdmin = CheckAdmin($_SESSION['idUser']);
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
                    <!-- Affichage des onglet -->
                    <?php if ($Admin_Modif) { //Modification d'un user par l'admin  ?>
                        <li class="active"><a href="#infos" data-toggle="tab" aria-expanded="false">Informations de l'utilisateur</a></li>
                        <li class=""><a href="#FormEditUser" data-toggle="tab" aria-expanded="false">Modifier l'utilisateur</a></li>
                    <?php } else { ?>
                        <li class="active"><a href="#infos" data-toggle="tab" aria-expanded="false">Mes Informations</a></li>
                        <li class=""><a href="#FormEditPwd" data-toggle="tab" aria-expanded="false">Modifier mon mot de passe</a></li>
                    <?php } ?>
                </ul>

                <!-- contenu des onglets -->
                <div id="info" class="tab-content">
                    <!-- Onglet d'information -->
                    <div class="tab-pane fade active in" id="infos">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="page-header">
                                <h2 class="text-center">
                                    <?php if ($Admin_Modif) { ?>
                                        Informations de l'utilisateur
                                    <?php } else { ?>
                                        Mes Informations
                                    <?php } ?>
                                </h2>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <p><b>Pseudo </b></p>
                                </div>
                                <div class="col-xs-8">
                                    <p> <?= $user['UserPseudo'] ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <p><b>Email </b></p>
                                </div>
                                <div class="col-xs-8">
                                    <p> <?= $user['UserEmail'] ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <p><b>Type d'utilisateur </b></p>
                                </div>
                                <div class="col-xs-8">
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
                                    <h2 class="text-center">Modifier mon mot de passe</h2>
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
                                    <h2 class="text-center">Modifier l'utilisateur</h2>
                                </div>

                                <!-- Formulaire de modification l'utilisateur -->
                                <form class="form col-md-12 center-block" action="#" method="post">
                                    <div class="form-group">
                                        <input type="text" name="AdminEditPseudo"  class="form-control" placeholder="Nouveau Pseudo"  value="<?= $user['UserPseudo'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <input type="email" pattern="^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$" name="AdminEditEmail"  class="form-control" placeholder="Nouvelle adress Email"  value="<?= $user['UserEmail'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <?php
                                        echo Select('AdminEditTypeUser', $TypeUser, $user['UserAdmin'], FALSE);
                                        ?>
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
                                        <button class="btn btn-primary btn-block" type="submit" name="AdminEditUser" id="btn-submit">Modifier</button>
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
            $(document).ready(function () {
                $("#EditNewPwd").keyup(function () {
                    checkPasswordMatch($("#EditNewPwd").val(), $("#RegisterConfirm").val());
                }
                );
                $("#EditNewPwdConfirm").keyup(function () {
                    checkPasswordMatch($("#EditNewPwd").val(), $("#EditNewPwdConfirm").val());
                }
                );
            });
        </script>

    </body>
</html>
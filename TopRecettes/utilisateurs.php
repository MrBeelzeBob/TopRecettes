<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015
-->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('./script/php/function.php');


//test si l'utilisateur est connecté
if (isset($_SESSION['idUser'])) {

//test si admin
    $isAdmin = CheckAdmin($_SESSION['idUser']);
    if ($isAdmin) {
        $users = get_users();
    } else {
        header('Location: ./');
        exit();
    }
} else {
    header('Location: ./');
    exit();
}
?>

<!doctype html>
<html lang="fr">
    <head>

        <meta charset="utf-8">
        <title>Gestion des utilisateurs </title>      
        <link href="script/css/bootstrap.min.css" rel="stylesheet">
        <link href="script/css/style.css" rel="stylesheet">
    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <?php include "liens_menu.php"; ?>    
        </nav>
        <header class="container page-header">
            <h1>TopRecettes <small>Gestion des utilisateurs</small></h1>
        </header>

        <section>
            <div class="container contenu">
                <div class="col-sm-8 col-sm-offset-2">
                    <div class="page-header">
                        <h2 class="text-center">Liste des utilisateurs</h2>
                    </div>

                </div>
                <div class="col-md-10 col-md-offset-1">
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <td>Pseudo</td>
                                <td>Email</td> 
                                <td>Type d'utilisateur</td>
                                <td>Edition</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) { ?>
                                <tr>
                                    <td><?= $user['UserPseudo'] ?></td>
                                    <td><?= $user['UserEmail'] ?></td> 
                                    <td>
                                        <?php
                                        if ($user['UserAdmin']) {
                                            echo 'Administrateur';
                                        }
                                        if (!$user['UserAdmin']) {
                                            echo 'Utilisateur';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="gererutilisateur.php?id=<?= $user['idUser'] ?>" class="btn btn-primary" title="Modifier">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                            Modifier
                                        </a>

                                        <a href="#ConfirmDeleteUser<?= $user['idUser']?>" data-toggle="modal" class="btn btn-primary" title="Supprimer">
                                            <span class="glyphicon glyphicon-trash"></span>
                                            Supprimer
                                        </a>
                                    </td>

                                </tr>

                                <!-- MODAL DE SUPRESSION DE RECETTE -->
                            <div class="modal fade" id="ConfirmDeleteUser<?= $user['idUser']?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>
                                                Etes-vous de sur de vouloir supprimer cet utilisateur ?
                                            </h4>
                                        </div> 
                                        <div class="modal-body">
                                            <a class="btn btn-default letf" data-dismiss="modal">Annuler</a>
                                            <a class="btn btn-primary right" href="supprimerutilisateur.php?idUser=<?= $user['idUser'] ?>">
                                                <span class="glyphicon glyphicon-trash"></span>
                                                Supprimer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </tbody>
                    </table>
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

    </body>
</html>
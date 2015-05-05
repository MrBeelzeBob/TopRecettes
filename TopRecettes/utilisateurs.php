
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
                    <table class="table table-bordered table-striped">
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
                                        <a href="gererutilisateur.php?id=<?= $user['idUser'] ?>" class="btn btn-primary btn-block" title="Modifier">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                            Modifier
                                        </a>
                                    </td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
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
    $('tbody tr').click(function () {
        window.location = $(this).find('a').attr('href');
    });
    $('tbody tr').hover(function () {
        $(this).toggleClass('hover');
    });
</script>

</body>
</html>
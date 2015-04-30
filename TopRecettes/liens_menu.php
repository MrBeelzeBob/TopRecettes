
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('script/php/function.php');
$connected = False;
$UserPseudo = 'Profil';

//test si l'utilisateur est connecté
if ((isset($_SESSION['idUser'])) AND ( isset($_SESSION['UserPseudo']))) {

    $UserPseudo = $_SESSION['UserPseudo'];
    $isAdmin = CheckAdmin($_SESSION['idUser']);
    $connected = TRUE;
}
?>
<!doctype html>

<div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
            <span class="sr-only">Toggle navigation</span>
            <span class="glyphicon glyphicon-list"></span>
        </button>
        <!-- Lien acceuil -->
        <a class="navbar-brand" href="./" title="Acceuil">
            
            <span class="glyphicon glyphicon-home"></span> TopRecettes
        </a>
    </div>

    <!--Liste des liens -->
    <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-left">
            <li><a href="recettes.php">Des Recettes</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">liens utiles <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="https://bootswatch.com/united/">Demo</a></li>
                    <li><a href="http://getbootstrap.com/components"/>Demo</a></li>
                </ul>
            </li>
        </ul>



        <!--    menu de gauche -->
        <ul class="nav navbar-nav navbar-right">

            <?php if ($connected) { ?>
                <!-- menu déroulant -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> 
                         <span class="glyphicon glyphicon-user"></span>
                        <?= $UserPseudo; ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="gerercompte.php">
                                <span class="glyphicon glyphicon-cog"></span> Mon compte
                            </a>
                        </li>
                        <?php if ($isAdmin) { ?>
                            <li class="divider"></li>
                            <li class="dropdown-header">Administrer</li>
                            <li>
                                <a href="gererutilisateur.php">
                                    <span class="glyphicon glyphicon-cog"></span> Gestion des utilisateurs
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="glyphicon glyphicon-cog"></span> Gestion des recettes
                                </a>
                            </li>
                        <?php } ?>

                        <li class="divider"></li>
                    </ul>
                </li>
                <li>
                    <a href="deconnexion.php" title="Déconexion">
                        <span class="glyphicon glyphicon-off"></span>
                    </a>
                </li>
            <?php } ?>
            <?php if (!$connected) { ?>

                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="inscription.php">Inscription</a></li>
            <?php } ?>
        </ul>
    </div>
</div>

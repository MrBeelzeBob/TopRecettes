<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015

Menu des utilisateurs - liens_menu.php
-->
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once('script/php/function.php');
$connected = False;
$UserPseudo = 'Profil';

//test si l'utilisateur est connecté
if (isset($_SESSION['idUser'])) {

    $UserPseudo = get_user_pseudo($_SESSION['idUser']);
    $isAdmin = CheckAdmin($_SESSION['idUser']);
    $connected = TRUE;
}
?>
<!doctype html>

<div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
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
            <?php if ($connected) { ?>
                <li><a href="editerrecette.php">Ajouter une recette</a></li>
            <?php } ?>

            <form class="navbar-form navbar-left" action="recettes.php" method="get" role="search">
                <div class="form-group">
                    <input type="text" name="search" id="search" class="form-control" placeholder="Rechercher ici.." required="">
                </div>
                <button type="submit" class="btn btn-primary" ><span class="glyphicon glyphicon-search"></span></button>
            </form>
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
                            <a href="gererutilisateur.php">
                                <span class="glyphicon glyphicon-cog"></span> Mon compte
                            </a>
                        </li>
                        <?php if ($isAdmin) { ?>
                            <li class="divider"></li>
                            <li class="dropdown-header">Administrer</li>
                            <li>
                                <a href="utilisateurs.php">
                                    <span class="glyphicon glyphicon-cog"></span> Gestion des utilisateurs
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

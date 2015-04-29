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

<div class="container">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse" >
            <span class="sr-only">Toggle navigation</span>
            <img  src="glyphicons_free/glyphicons/glyphicons-115-list.png">
        </button>
        <!-- Lien acceuil -->
        <a class="navbar-brand" href="./" title="Acceuil">
            <img height="25" style="display: inline;" src="glyphicons_free/glyphicons/glyphicons-21-home.png"> TopRecettes
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
                        <img class="glyph" src="glyphicons_free/glyphicons/glyphicons-4-user.png">
                        <?= $UserPseudo; ?> <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#"><img height="15px" src="glyphicons_free/glyphicons/glyphicons-137-cogwheel.png"> Mon compte</a></li>
                        <?php if ($isAdmin) { ?>
                            <li class="divider"></li>
                            <li class="dropdown-header">Administrer</li>
                            <li><a href="#"><img height="15px" src="glyphicons_free/glyphicons/glyphicons-138-cogwheels.png"> Gestion des utilisateurs</a></li>
                            <li><a href="#"><img height="15px" src="glyphicons_free/glyphicons/glyphicons-138-cogwheels.png"> Gestion des recettes</a></li>
                        <?php } ?>

                        <li class="divider"></li>
                    </ul>
                </li>
                <li><a href="deconnexion.php" title="Déconexion" ><img height="15px" alt="Déconnexion" src="glyphicons_free/glyphicons/glyphicons-64-power.png"> </a> </li>
            <?php } ?>
            <?php if (!$connected) { ?>

                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="inscription.php">Inscription</a></li>
            <?php } ?>
        </ul>
    </div>
</div>

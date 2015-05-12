<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015
-->
<?php
    session_start();  //Creer une session
    session_destroy(); //Detruit la session
    session_start();  //Creer une session
    header("Location: index.php");  //Renvoy a la page index
?>

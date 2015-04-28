<!--
Cedric Dos Reis
I.IN-P4A

logout.php
-->
<?php
    session_start();  //Creer une session
    session_destroy(); //Detruit la session
    session_start();  //Creer une session
    header("Location: index.php");  //Renvoy a la page index
?>

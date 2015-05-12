<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015
-->

<?php

/**
 * Connexion à la base de données
 * @staticvar type $pdo
 * @return \PDO
 */
function connectDB() {
    static $pdo = null;
    if ($pdo === null) {
        $user = 'root';
        $password = '';
        $pdo = new PDO('mysql:host=localhost;dbname=toprecettes', $user, $password);
        $pdo->exec('set character set utf8');
    }
    return $pdo;
}
?>



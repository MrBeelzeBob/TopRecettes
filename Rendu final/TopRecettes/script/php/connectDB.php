<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015

Connexion à la base de données - connectDB.php
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
        $user = 'User_TopRecettes';
        $password = 'TopRecettes2015';
        $pdo = new PDO('mysql:host=localhost;dbname=toprecettes', $user, $password);
        $pdo->exec('set character set utf8');
    }
    return $pdo;
}
?>



<?php

/**
 * 
 * @staticvar type $pdo
 * @return \PDO
 */
function connectDB() {

    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO('mysql:host=localhost;dbname=toprecettes', 'root', '');
        $pdo->exec('set character set utf8');
    }
    return $pdo;
}

?>



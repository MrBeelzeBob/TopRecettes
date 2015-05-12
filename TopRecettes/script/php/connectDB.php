<?php

/**
 * 
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



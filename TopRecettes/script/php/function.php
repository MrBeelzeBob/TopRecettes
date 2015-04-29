<?php
require_once('connectDB.php');
require_once('outilsFormulaire.php');

/**
 * 
 * @param type $var
 */
function var_dump_pre($var) {
    echo '<pre>';
    echo var_dump($var);
    echo '</pre>';
}

/**
 * Debug function
 * Affichage pour debuggage du contenu passé en parametre
 * @param mixed $sObj element à afficher optionnel
 * @return null
 */
function debug($sObj = NULL) {
    echo '<pre>';

    if (is_null($sObj)) {
        echo '|Object is NULL|' . "\n";
    } else if (is_array($sObj) || is_object($sObj)) {
        var_dump($sObj);
    } else {
        echo '|' . $sObj . '|' . "\n";
    }

    echo '</pre>';
}

/**
 * 
 * @param type $Message
 * @return string
 */
function MessageErreur($Message) {
    $text = '  <div class="col-sm-6 col-sm-offset-3 alert alert-dismissible alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <p style="text-align: center;">' . $Message . '</p>
                </div>';
    return $text;
}

/**
 * 
 * @param type $UserEmail
 * @param type $UserPassword
 * @return boolean
 */
function login($UserEmail, $UserPassword) {
    $pdo = connectDB();

    $query = "SELECT idUser, UserPseudo, UserAdmin FROM tUser WHERE UserEmail = :UserEmail AND UserPassword = :UserPassword ;";

    $statement = $pdo->prepare($query);
    $statement->execute(array(":UserEmail" => $UserEmail,
        ":UserPassword" => $UserPassword));
    $statement = $statement->fetch();

    if ($statement) {
        $_SESSION['idUser'] = $statement["idUser"];
        $_SESSION['UserPseudo'] = $statement["UserPseudo"];
        return true;
    }
    return false;
}

/**
 * 
 * @param type $UserPseudo
 * @param type $UserEmail
 * @param type $UserPassword
 * @return boolean
 */
function register($UserPseudo, $UserEmail, $UserPassword) {

//Vérifie si le pseuod ou le mail existe déjà
    $exist = CheckExist_Pseudo_Email($UserPseudo, $UserEmail);

    if (!$exist) {
        $pdo = connectDB();

//insert les données dans la base
        $query = 'INSERT INTO tUser (UserPseudo, UserEmail, UserPassword) VALUES (:UserPseudo, :UserEmail, :UserPassword);';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":UserPseudo" => $UserPseudo,
            ":UserEmail" => $UserEmail,
            ":UserPassword" => $UserPassword));
        $statement = $statement->fetch();

        return true;
    } else {
        return false;
    }
}

/**
 * Lors de l'inscription, vérifie si le pseudo ou l'email est déjà utilisé
 * @param type $UserPseudo
 * @param type $UserEmail
 * @param type $UserPassword
 * @return boolean
 */
function CheckExist_Pseudo_Email($UserPseudo, $UserEmail) {
    try {
        $pdo = connectDB();

//vérifie si l'email ou le pseudo sont déja utilisé
        $query = 'SELECT UserPseudo FROM tUser WHERE UserPseudo = :UserPseudo OR UserEmail = :UserEmail ;';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":UserPseudo" => $UserPseudo,
            ":UserEmail" => $UserEmail));
        $statement = $statement->fetch();

//vérifie si une valeur est récupérée
        if ($statement) {
            return true; //existe
        }
        if ($statement == false) {
            return false; //existe pas
        }
    } catch (Exception $ex) {
        echo 'Une erreur est survenue' . $ex->getMessage();
        return;
    }
}

/**
 * 
 * @param type $idUser
 * @return boolean
 */
function CheckAdmin($idUser) {
    try {
        $pdo = connectDB();
        //recupere une valeur pour vérifier si l'utilisateur est admin
        $query = 'SELECT UserAdmin FROM tUser WHERE idUser = :idUser;';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":idUser" => $idUser));
        $statement = $statement->fetch();

        if ($statement['UserAdmin']) {
            return true;
        }
        return false;
    } catch (Exception $ex) {
        echo 'Une erreur est survenue' . $ex->getMessage();
        return;
    }
}

/**
 * 
 * @param type $trie
 * @param type $search
 * @return type
 */
function get_recipes($tri, $recherche, $idUser) {
    try {
        $pdo = connectDB();

        $query = 'SELECT trecipe.idRecipe, trecipe.RecipeTitle, trecipe.RecipeImage, trecipe.RecipeDate, tuser.UserPseudo '
                . 'FROM trecipe '
                . 'NATURAL JOIN tuser ';

        if (!empty($search)) {
            $query .= 'WHERE trecipe.RecipeTitle REGEXP ' . $recherche;
        }

        switch ($tri) {
            case 1: $query .= 'ORDER BY trecipe.RecipeDate DESC ;';
            case 2: $query .= 'ORDER BY trecipe.RecipeDate ASC ;';
            case 3: $query .= ' ';
            case 4: $query .= ' ';
            case 5:
                if (!empty($idUser)) { //vérifie si l'iduser n'est pas vide
                    $query .= 'WHERE trecipe.idUser = ' . $idUser;
                }
        }

        $statement = $pdo->prepare($query);
        $statement->execute();
        $statement = $statement->fetchall();

        return $statement;
    } catch (Exception $ex) {
        echo 'Une erreur est survenue' . $ex->getMessage();
        return;
    }
}

/**
 * 
 * @param type $idRecipe
 */
function get_recipe($idRecipe) {
    try {
        $pdo = connectDB();

        $query = 'SELECT trecipe.idRecipe, trecipe.RecipeTitle, trecipe.RecipeContenu, trecipe.RecipeOrigin, '
                . 'trecipe.RecipeImage, GROUP_CONCAT(tcategory.CategoryName) AS Categories '
                . 'FROM trecipe '
                . 'NATURAL JOIN tcategory '
                . 'WHERE trecipe.idRecipe =  :idRecipe';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":idRecipe" => $idRecipe));
        $statement = $statement->fetch();
        return $statement;
    } catch (Exception $ex) {
        echo 'Une erreur est survenue' . $ex->getMessage();
        return;
    }
}

/**
 * 
 * @param type $idRecipe
 * @return type
 */
function get_ingredients_recipe($idRecipe) {
    try {
        $pdo = connectDB();

        $query = 'SELECT contains.ContainsQuantity, contains.ContainsUnit, tingredient.IngredientName '
                . 'FROM contains '
                . 'LEFT JOIN tingredient ON tingredient.idIngredient = contains.idIngredient '
                . 'WHERE contains.idRecipe = :idRecipe';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":idRecipe" => $idRecipe));
        $statement = $statement->fetchAll();
        return $statement;
    } catch (Exception $ex) {
        echo 'Une erreur est survenue' . $ex->getMessage();
        return;
    }
}

/**
 * 
 * @param type $idRecipe
 * @return type
 */
function get_comments_recipe($idRecipe) {
    try {
        $pdo = connectDB();

        $query = 'SELECT comments.idComment, comments.CommentText, tuser.UserPseudo '
                . 'FROM comments '
                . 'NATURAL JOIN tuser '
                . 'WHERE idRecipe = :idRecipe';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":idRecipe" => $idRecipe));
        $statement = $statement->fetchAll();

        return $statement;
    } catch (Exception $ex) {
        echo 'Une erreur est survenue' . $ex->getMessage();
        return;
    }
}

/**
 * upload les vignettes et les hymnes dans le dossier des upload
 * ajoute dans la BD le chemin d'accès du fichier uploadé
 * @param type $name nom du fichier
 * @param type $type type du fichier
 * @return string
 */ function upload($fichier, $type) {

    if ($type == 'console') {
        $uploaddir = './uploads/consoles/';
        $path_info = pathinfo($fichier['name']);
        $extension = $path_info['extension'];
        $temp_file_name = uniqid('console_', false) . '.' . $extension;
        $uploadfile = $uploaddir . $temp_file_name;
        move_uploaded_file($fichier['tmp_name'], $uploadfile);
    }
    if ($type == 'jeu') {
        $uploaddir = './uploads/jeux/';
        $path_info = pathinfo($fichier['name']);
        $extension = $path_info['extension'];
        $temp_file_name = uniqid('jeu_', false) . '.' . $extension;
        $uploadfile = $uploaddir . $temp_file_name;
        move_uploaded_file($fichier['tmp_name'], $uploadfile);
    }
    return $uploadfile;
}
?>


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
function ShowError($Message) {
    echo ' <div class="col-sm-6 col-sm-offset-3 alert alert-dismissible alert-danger"> ';
    echo '<button type="button" class="close" data-dismiss="alert">×</button>';
    echo '<p style="text-align: center;">' . $Message . '</p>';
    echo '</div>';
}

function ShowSuccess($Message) {
    echo ' <div class="col-sm-6 col-sm-offset-3 alert alert-dismissible alert-success"> ';
    echo '<button type="button" class="close" data-dismiss="alert">×</button>';
    echo '<p style="text-align: center;">' . $Message . '</p>';
    echo '</div>';
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

    $pdo = connectDB();

//insert les données dans la base
    $query = 'INSERT INTO tUser (UserPseudo, UserEmail, UserPassword) VALUES (:UserPseudo, :UserEmail, :UserPassword);';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":UserPseudo" => $UserPseudo,
        ":UserEmail" => $UserEmail,
        ":UserPassword" => $UserPassword));
    $statement = $statement->fetch();

    return true;
}

/**
 * Lors de l'inscription, vérifie si le pseudo ou l'email est déjà utilisé
 * @param type $UserPseudo
 * @param type $UserEmail
 * @param type $UserPassword
 * @return boolean
 */
function CheckExist_Pseudo($UserPseudo) {

    $pdo = connectDB();

//vérifie le pseudo est déja utilisé
    $query = 'SELECT UserPseudo FROM tUser WHERE UserPseudo = :UserPseudo;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":UserPseudo" => $UserPseudo));
    $statement = $statement->fetch();

//vérifie si une valeur est récupérée
    if ($statement) {
        return true; //existe
    }
    if ($statement == false) {
        //existe pas
    }
}

/**
 * 
 * @return boolean
 */
function CheckExist_Email($UserEmail) {
    $pdo = connectDB();

    $query = 'SELECT UserEmail FROM tUser WHERE UserEmail = :UserEmail ;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":UserEmail" => $UserEmail));
    $statement = $statement->fetch();
    if ($statement) {
        return true; //existe
    }
    if ($statement == false) {
        return false; //existe pas
    }
}

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
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
        return;
    }
}

function get_recipes($sort, $search, $idUser) {
    try {
        $pdo = connectDB();

        $query = 'SELECT trecipe.idRecipe, trecipe.RecipeTitle, trecipe.RecipeImage, trecipe.RecipeDate, tuser.UserPseudo '
                . 'FROM trecipe '
                . 'NATURAL JOIN tuser ';

        if (!empty($search)) {
            $query .= 'WHERE trecipe.RecipeTitle REGEXP ' . $search;
        }

        switch ($sort) {
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
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
        return;
    }
}

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
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
        return;
    }
}

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
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
        return;
    }
}

function get_comments_recipe($idRecipe) {
    try {
        $pdo = connectDB();

        $query = 'SELECT comments.idComment, comments.CommentText, comments.CommentDate, tuser.UserPseudo '
                . 'FROM comments '
                . 'NATURAL JOIN tuser '
                . 'WHERE comments.idRecipe = :idRecipe '
                . 'ORDER BY comments.CommentDate DESC';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":idRecipe" => $idRecipe));
        $statement = $statement->fetchAll();

        return $statement;
    } catch (Exception $ex) {
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
        return;
    }
}

function add_comment($idUser, $idRecipe, $comment) {
    try {
        $pdo = connectDB();

        $date = date('Y-m-d H:i:s', time());

        $query = 'INSERT INTO comments (CommentText, CommentDate, idUser, idRecipe) VALUES (:CommentText, :CommentDate, :idUser, :idRecipe)';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":idUser" => $idUser,
            ":idRecipe" => $idRecipe,
            ":CommentText" => $comment,
            ":CommentDate" => $date));
        $statement = $statement->fetch();

        return;
    } catch (Exception $ex) {
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
        return;
    }
}

function get_users() {
    try {
        $pdo = connectDB();

        $query = 'SELECT idUser, UserEmail, UserPseudo, UserAdmin FROM tuser';
        $statement = $pdo->prepare($query);
        $statement->execute();
        $statement = $statement->fetchAll();

        return $statement;
    } catch (Exception $ex) {
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
        return;
    }
}

function get_user($idUser) {
    try {
        $pdo = connectDB();

        $query = 'SELECT UserEmail, UserPseudo, UserAdmin FROM tuser WHERE idUser = :idUser';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":idUser" => $idUser));
        $statement = $statement->fetch();

        return $statement;
    } catch (Exception $ex) {
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
        return;
    }
}

function check_password($idUser, $password) {
    try {
        $pdo = connectDB();

        $query = 'SELECT UserPassword FROM tuser WHERE idUser = :idUser';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":idUser" => $idUser));
        $statement = $statement->fetch();

        if ($statement['UserPassword'] == $password) {
            return true;
        }

        return false;
    } catch (Exception $ex) {
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
        return;
    }
}

function edit_user($NewPseudo, $NewEmail, $idUser) {
    try {
        $pdo = connectDB();
        if ((!empty($NewPseudo)) AND (empty($NewEmail))) { //test si le pseudo n'est pas vide et si l'email est vide
            $ToDo = 1; //modifie le pseudo uniquement
        }
        if ((!empty($NewEmail)) AND (empty($NewPseudo))) { //test si l'email n'est pas vide et si le pseudo est vide
            $ToDo = 2; //modifie l'email uniquement
        }
        if ((!empty($NewPseudo)) AND (!empty($NewEmail))) { //test si le pseudo et le mot de passe ne sont pas vide
            $ToDo = 3; //modifie le pseudo et l'email
        }

        switch ($ToDo) {
            case 1: $query = 'UPDATE tuser SET UserPseudo = :UserPseudo WHERE idUser = :idUser;';
                $statement = $pdo->prepare($query);
                $statement->execute(array(":idUser" => $idUser,
                    ":UserPseudo" => $NewPseudo));
                break;
                
            case 2: $query = 'UPDATE tuser SET UserEmail = :UserEmail  WHERE idUser = :idUser;';
                $statement = $pdo->prepare($query);
                $statement->execute(array(":idUser" => $idUser,
                    ":UserEmail" => $NewEmail));
                break;
                
            case 3: $query = 'UPDATE tuser SET UserPseudo = :UserPseudo, UserEmail = :UserEmail  WHERE idUser = :idUser;';
                $statement = $pdo->prepare($query);
                $statement->execute(array(":idUser" => $idUser,
                    ":UserPseudo" => $NewPseudo,
                    ":UserEmail" => $NewEmail));
                break;
        }


        $statement = $statement->fetch();
        return true;
    } catch (Exception $ex) {
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
        return false;
    }
}

function edit_user_password($idUser, $NewPassword) {
    try {

        $pdo = connectDB();

        $query = 'UPDATE tuser SET UserPassword = :UserPassword WHERE idUser = :idUser;';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":idUser" => $idUser,
            ":UserPassword" => $NewPassword));
        $statement = $statement->fetch();

        return true;
    } catch (Exception $ex) {
        ShowError('Une erreur est survenue : ' . $ex->getMessage());
        return false;
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


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

function login($UserEmail, $UserPassword) {
    $pdo = connectDB();
    $query = "SELECT idUser, UserPseudo, UserAdmin FROM tUser WHERE UserEmail = :UserEmail AND UserPassword = :UserPassword ;";
    $statement = $pdo->prepare($query);
    $statement->execute(array(":UserEmail" => $UserEmail,
        ":UserPassword" => $UserPassword));
    $statement = $statement->fetch();
    if ($statement) {
        $_SESSION['idUser'] = $statement["idUser"];
        return true;
    }
    return false;
}

function register($UserPseudo, $UserEmail, $UserPassword) {
    $pdo = connectDB();
//insert les données dans la base
    $query = 'INSERT INTO tuser (UserPseudo, UserEmail, UserPassword) VALUES (:UserPseudo, :UserEmail, :UserPassword);';
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

        $query = 'SELECT trecipe.idRecipe, trecipe.RecipeTitle, trecipe.RecipeImage, trecipe.RecipeDate, trecipe.idUser '
                . 'FROM trecipe ';
        if (!empty($search)) {
            $query .= 'WHERE trecipe.RecipeTitle REGEXP "' . $search.'"';
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
        $query = 'SELECT trecipe.idRecipe, trecipe.RecipeTitle, trecipe.RecipePreparation, trecipe.RecipeOrigin, trecipe.idType, '
                . 'trecipe.RecipeImage, trecipe.idUser, ttype.TypeName '
                . 'FROM trecipe '
                . 'NATURAL JOIN ttype '
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

function add_recipe($RecipeInfos, $idUser, $PathImage) {


    echo 'dossier img ' . $PathImage;
    echo 'id ' . $idUser;
    $pdo = connectDB();
    $date = date('Y-m-d', time()); //recupere la date

    $query = 'INSERT INTO trecipe (RecipeTitle, RecipePreparation, RecipeOrigin, idType, RecipeImage, idUser, RecipeDate) '
            . 'VALUES(:RecipeTitle, :RecipePreparation, :RecipeOrigin, :idType, :RecipeImage, :idUser, :RecipeDate)';

    $statement = $pdo->prepare($query);
    $statement->execute(array(":RecipeTitle" => $RecipeInfos['RecipeTitle'],
        ":RecipePreparation" => $RecipeInfos['RecipePreparation'],
        ":RecipeOrigin" => $RecipeInfos['RecipeOrigin'],
        ":idType" => $RecipeInfos['idType'],
        ":RecipeImage" => $PathImage,
        ":idUser" => $idUser,
        ":RecipeDate" => $date));
    $statement = $statement->fetch();

    return $pdo->lastinsertid();
}

function edit_recipe($idRecipe, $RecipeInfos) {
    var_dump_pre($RecipeInfos);
    
    $pdo = connectDB();

    $query = 'UPDATE trecipe SET RecipeTitle = :RecipeTitle, RecipePreparation = :RecipePreparation, RecipeOrigin = :RecipeOrigin, idType = :idType '
            . 'WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe,
        ":RecipeTitle" => $RecipeInfos['RecipeTitle'],
        ":RecipePreparation" => $RecipeInfos['RecipePreparation'],
        ":RecipeOrigin" => $RecipeInfos['RecipeOrigin'],
        ":idType" => $RecipeInfos['idType']));
    $statement = $statement->fetch();
}

function get_ingredients() {
    $pdo = connectDB();
    $query = 'SELECT * FROM tingredient';
    $statement = $pdo->prepare($query);
    $statement->execute();
    $statement = $statement->fetchAll();
    return $statement;
}

function count_ingredient_recipe($idRecipe) {
    $pdo = connectDB();
    $query = 'SELECT count(idIngredient) AS RecipeNbIngredient FROM contains WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    return $statement;
}

function checkExist_ingredient($IngredientName) {
    $pdo = connectDB();
    $query = 'SELECT idIngredient FROM tingredient WHERE IngredientName = :IngredientName';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":IngredientName" => $IngredientName));
    $statement = $statement->fetch();
    return $statement['idIngredient'];
}

function add_ingredient($IngredientName) {
    $IngredientName = strtoupper($IngredientName); //renvoi l'ingredient en majuscule 

    $pdo = connectDB();
    $query = 'INSERT INTO tingredient (IngredientName) VALUES(:IngredientName)';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":IngredientName" => $IngredientName));
    $statement = $statement->fetch();
    return $pdo->lastInsertId();
}

function ingredients_associate() {
    //TRANSFORM ARRAY IN ASSOCIATIF ARRAY FOR INGREDIENTS
    $table = get_ingredients();
    //$table_associate = array('' => 'non defini');
    foreach ($table as $ingredient) {
        $table_associate[$ingredient['idIngredient']] = $ingredient['IngredientName'];
    }
    return $table_associate;
}

function add_contains($idIngredient, $IngredientQuantity, $idNewRecipe) {
    $pdo = connectDB();
    $query = 'INSERT INTO contains (ContainsQuantity, idRecipe, idIngredient) VALUES(:ContainsQuantity, :idRecipe, :idIngredient)';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":ContainsQuantity" => $IngredientQuantity,
        ":idIngredient" => $idIngredient,
        ":idRecipe" => $idNewRecipe));
    $statement = $statement->fetch();
    return $pdo->lastInsertId();
}

function get_ingredients_recipe($idRecipe) {
    try {
        $pdo = connectDB();
        $query = 'SELECT contains.ContainsQuantity, tingredient.IngredientName '
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
        $query = 'SELECT comments.idComment, comments.CommentText, comments.CommentDate, comments.idUser '
                . 'FROM comments '
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

function get_recipe_types() {
    $pdo = connectDB();
    $query = 'SELECT * FROM ttype';
    $statement = $pdo->prepare($query);
    $statement->execute();
    $statement = $statement->fetchAll();
    return $statement;
}

function recipe_types_associate() {
    //TRANSFORM ARRAY IN ASSOCIATIF ARRAY FOR INGREDIENTS
    $table = get_recipe_types();
    $table_associate = array('' => 'Type de plat');
    foreach ($table as $type) {
        $table_associate[$type['idType']] = $type['TypeName'];
    }
    return $table_associate;
}

function add_comment($idUser, $idRecipe, $comment, $note) {
    try {
        $pdo = connectDB();
        $date = date('Y-m-d H:i:s', time()); //recupere la date et l'heure
        $query = 'INSERT INTO comments (CommentText, CommentNote, CommentDate, idUser, idRecipe) VALUES (:CommentText, :CommentNote, :CommentDate, :idUser, :idRecipe)';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":idUser" => $idUser,
            ":idRecipe" => $idRecipe,
            ":CommentText" => $comment,
            ":CommentNote" => $note,
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

function get_user_pseudo($idUser) {
    $pdo = connectDB();

    $query = 'SELECT UserPseudo FROM tuser WHERE idUser = :idUser';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return $statement['UserPseudo'];
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
        if ((!empty($NewPseudo)) AND ( empty($NewEmail))) { //test si le pseudo n'est pas vide et si l'email est vide
            $ToDo = 1; //modifie le pseudo uniquement
        }
        if ((!empty($NewEmail)) AND ( empty($NewPseudo))) { //test si l'email n'est pas vide et si le pseudo est vide
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

function set_administrateur($UserAdmin, $idUser) {
    $pdo = connectDB();
    $query = 'UPDATE tuser SET UserAdmin = :UserAdmin WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser,
        ":UserAdmin" => $UserAdmin));
    $statement = $statement->fetch();
    return true;
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
 * Supprime l'utilisateur dont l'id est reçu en paramètre
 * @param type $idUser_ToDelete 
 * @return boolean
 */
function delete_user($idUser) {
    $pdo = connectDB();

    $query = 'DELETE FROM tuser WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return true;
}

function delete_link_user_recipes($idUser) {
    $pdo = connectDB();
    $query = 'UPDATE comments SET idUser = "0" WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return;
}

function delete_link_user_comments($idUser) {
    $pdo = connectDB();
    $query = 'UPDATE trecipe SET idUser = "0" WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return;
}

function check_owner_recipe($idUser, $idRecipe) {

    $pdo = connectDB();
//recupere une valeur pour vérifier si l'utilisateur est propriétaire du commentaire
    $query = 'SELECT idUser FROM trecipe WHERE idRecipe = :idRecipe;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    if ($statement['idUser'] === $idUser) {
        return true;
    }
    return false;
}

function check_owner_comment($idUser, $idComment) {

    $pdo = connectDB();
//recupere une valeur pour vérifier si l'utilisateur est propriétaire du commentaire
    $query = 'SELECT idUser FROM comment WHERE idComment = :idComment;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idComment" => $idComment));
    $statement = $statement->fetch();
    if ($statement['idUser'] === $idUser) {
        return true;
    }
    return false;
}

function delete_comment($idComment) {
    $pdo = connectDB();

    $query = 'DELETE FROM comments WHERE idComment = :idComment';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idComment" => $idComment));
    $statement = $statement->fetch();
}

function delete_contains_recipe($idRecipe) {
    $pdo = connectDB();

    $query = 'DELETE FROM contains WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
}


function get_top_recipes() {
    $pdo = connectDB();
    $query = 'SELECT *, AVG(Note) as avg_note
            FROM noter
            NATURAL JOIN t_videos
            GROUP BY nomVideo
            ORDER BY avg_note DESC ';
    $statement = $pdo->prepare($query);
    $statement->execute();
    $statement = $statement->fetchAll();
    return $statement;
}

function get_avg_note_recipe($idRecipe) {
    $pdo = connectDB();
    $query = 'SELECT idRecipe, AVG(comments.CommentNote) as avg FROM comments WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    $text = NULL;
    
    for ($i = 1; $i <= $statement['avg']; $i++) {
            $text .= '<span class="glyphicon glyphicon-star"></span>';
    }
    return $text;
    
}

/**
 * upload les vignettes et les hymnes dans le dossier des upload
 * ajoute dans la BD le chemin d'accès du fichier uploadé
 * @param type $name nom du fichier
 * @param type $type type du fichier
 * @return string
 */ function upload($file) {

    $uploaddir = './imgRecettes/';
    $path_info = pathinfo($file['name']);
    $extension = $path_info['extension'];
    $temp_file_name = uniqid('', false) . '.' . $extension;
    $uploadfile = $uploaddir . $temp_file_name;
    move_uploaded_file($file['tmp_name'], $uploadfile);

    return $uploadfile;
}
?>


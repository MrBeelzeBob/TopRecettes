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
    echo '<div class="message col-sm-6 col-sm-offset-3 alert alert-dismissible alert-danger"> ';
    echo '<button type="button" class="close" data-dismiss="alert">×</button>';
    echo '<p style="text-align: center;">' . $Message . '</p>';
    echo '</div>';
}

function ShowSuccess($Message) {
    echo '<div class="message col-sm-6 col-sm-offset-3 alert alert-dismissible alert-success"> ';
    echo '<button type="button" class="close" data-dismiss="alert">×</button>';
    echo '<p style="text-align: center;">' . $Message . '</p>';
    echo '</div>';
}

function login($UserEmail, $UserPassword) {
    $pdo = connectDB();
    $query = "SELECT idUser, UserPseudo, UserAdmin FROM tusers WHERE UserEmail = :UserEmail AND UserPassword = :UserPassword ;";
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
    $query = 'INSERT INTO tusers (UserPseudo, UserEmail, UserPassword) VALUES (:UserPseudo, :UserEmail, :UserPassword);';
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
    $query = 'SELECT UserPseudo FROM tusers WHERE UserPseudo = :UserPseudo;';
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
    $query = 'SELECT UserEmail FROM tusers WHERE UserEmail = :UserEmail ;';
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
    $pdo = connectDB();
//recupere une valeur pour vérifier si l'utilisateur est admin
    $query = 'SELECT UserAdmin FROM tusers WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    if ($statement['UserAdmin']) {
        return true;
    }
    return false;
}

function get_recipes($sort, $search, $idUser, $limit) {
    $pdo = connectDB();

    $query = 'SELECT trecipes.idRecipe, trecipes.RecipeTitle, trecipes.RecipeImage, trecipes.RecipeDate, trecipes.idUser, AVG(tcomments.CommentNote) AS RecipeAVG '
            . 'FROM trecipes '
            . 'LEFT JOIN tcomments ON tcomments.idRecipe = trecipes.idRecipe ';


    switch ($sort) {
        case NULL:
            if (!empty($search)) {
                $query .= 'WHERE trecipes.RecipeTitle REGEXP "' . $search . '" ';
            }
            $query .= 'GROUP BY trecipes.idRecipe '
                    . 'ORDER BY trecipes.RecipeTitle ';
            break;
        case 1:
            if (!empty($search)) {
                $query .= 'WHERE trecipes.RecipeTitle REGEXP "' . $search . '" ';
            }
            $query .= 'GROUP BY trecipes.idRecipe '
                    . 'ORDER BY trecipes.RecipeDate DESC ';
            break;
        case 2:
            if (!empty($search)) {
                $query .= 'WHERE trecipes.RecipeTitle REGEXP "' . $search . '" ';
            }
            $query .= 'GROUP BY trecipes.idRecipe '
                    . 'ORDER BY trecipes.RecipeDate ASC ';
            break;
        case 3:
            if (!empty($search)) {
                $query .= 'WHERE trecipes.RecipeTitle REGEXP "' . $search . '" ';
            }
            $query .= 'GROUP BY trecipes.idRecipe '
                    . 'ORDER BY RecipeAVG DESC ';
            break;
        case 4:
            if (!empty($search)) {
                $query .= 'WHERE trecipes.RecipeTitle REGEXP "' . $search . '" ';
            }
            $query .= 'GROUP BY trecipes.idRecipe '
                    . 'ORDER BY RecipeAVG ASC ';

            break;
        case 5:
            if (!empty($search)) {
                $query .= 'WHERE trecipes.RecipeTitle REGEXP "' . $search . '" AND trecipes.idUser = ' . $idUser . ' ';
            } else {
                $query .= 'WHERE trecipes.idUser = ' . $idUser . ' ';
            }
            $query .= 'GROUP BY trecipes.idRecipe '
                    . 'ORDER BY RecipeTitle ';
            break;
    }//end switch

    if (!empty($limit)) {  //Ajoute une limit de recettes à récupéré
        $query .= 'Limit 4 ';
    }
    $statement = $pdo->prepare($query);
    $statement->execute();
    $statement = $statement->fetchall();

    return $statement;
}

function get_recipe($idRecipe) {
    $pdo = connectDB();
    $query = 'SELECT trecipes.idRecipe, trecipes.RecipeTitle, trecipes.RecipePreparation, trecipes.RecipeOrigin, trecipes.idType, AVG(tcomments.CommentNote) AS RecipeAVG, '
            . 'trecipes.RecipeImage, trecipes.idUser, ttypes.TypeName '
            . 'FROM trecipes '
            . 'NATURAL JOIN ttypes '
            . 'LEFT JOIN tcomments ON tcomments.idRecipe = trecipes.idRecipe '
            . 'WHERE trecipes.idRecipe =  :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    return $statement;
}

function add_recipe($RecipeInfos, $idUser) {
    $pdo = connectDB();
    $date = date('Y-m-d', time()); //recupere la date
//Test si l'image doit aussi etre modifier
    if (!empty($RecipeInfos['RecipeImage_New']['name'])) {
        $PathImage = upload($RecipeInfos['RecipeImage_New']); //upload la nouvelle image
//AJOUTE LA RECETTE AVEC L'IMAGE
        $query = 'INSERT INTO trecipes (RecipeTitle, RecipePreparation, RecipeOrigin, idType, RecipeImage, idUser, RecipeDate) '
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
    } else {
//AJOUTE LA RECETTE SANS IMAGE
        $query = 'INSERT INTO trecipes (RecipeTitle, RecipePreparation, RecipeOrigin, idType, idUser, RecipeDate) '
                . 'VALUES(:RecipeTitle, :RecipePreparation, :RecipeOrigin, :idType, :idUser, :RecipeDate)';

        $statement = $pdo->prepare($query);
        $statement->execute(array(":RecipeTitle" => $RecipeInfos['RecipeTitle'],
            ":RecipePreparation" => $RecipeInfos['RecipePreparation'],
            ":RecipeOrigin" => $RecipeInfos['RecipeOrigin'],
            ":idType" => $RecipeInfos['idType'],
            ":idUser" => $idUser,
            ":RecipeDate" => $date));
        $statement = $statement->fetch();

        return $pdo->lastinsertid();
    }
}

function edit_recipe($idRecipe, $RecipeInfos) {

    var_dump_pre($RecipeInfos);

    $pdo = connectDB();

//Test si l'image doit aussi etre modifier
    if (!empty($RecipeInfos['RecipeImage_New']['name'])) {
        if ($RecipeInfos['RecipeImage'] == './imgRecettes/toprecette.jpg') { //Teste si l'image actuel est celle par défaut
            $PathImage = upload($RecipeInfos['RecipeImage_New']); //upload la nouvelle image
        } else {
            unlink($RecipeInfos['RecipeImage']); //supprime l'ancienne image
            $PathImage = upload($RecipeInfos['RecipeImage_New']); //upload la nouvelle image
        }
//MODIFIE LA RECETTE AVEC L'IMAGE
        $query = 'UPDATE trecipes SET RecipeTitle = :RecipeTitle, RecipePreparation = :RecipePreparation, RecipeOrigin = :RecipeOrigin, idType = :idType, RecipeImage = :RecipeImage '
                . 'WHERE idRecipe = :idRecipe';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":idRecipe" => $idRecipe,
            ":RecipeTitle" => $RecipeInfos['RecipeTitle'],
            ":RecipePreparation" => $RecipeInfos['RecipePreparation'],
            ":RecipeOrigin" => $RecipeInfos['RecipeOrigin'],
            ":idType" => $RecipeInfos['idType'],
            ":RecipeImage" => $PathImage));
        $statement = $statement->fetch();
        return;
    } else {
//MODIFIE LA RECETTE SANS MODIFIER L'IMAGE
        $query = 'UPDATE trecipes SET RecipeTitle = :RecipeTitle, RecipePreparation = :RecipePreparation, RecipeOrigin = :RecipeOrigin, idType = :idType '
                . 'WHERE idRecipe = :idRecipe';
        $statement = $pdo->prepare($query);
        $statement->execute(array(":idRecipe" => $idRecipe,
            ":RecipeTitle" => $RecipeInfos['RecipeTitle'],
            ":RecipePreparation" => $RecipeInfos['RecipePreparation'],
            ":RecipeOrigin" => $RecipeInfos['RecipeOrigin'],
            ":idType" => $RecipeInfos['idType']));
        $statement = $statement->fetch();
        return;
    }
}

function delete_recipe($idRecipe) {
    $pdo = connectDB();

    $query = 'DELETE FROM trecipes WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    return;
}

function get_recipe_image($idRecipe) {
    $pdo = connectDB();

    $query = 'Select RecipeImage FROM trecipes WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    if ($statement['RecipeImage'] == './imgRecettes/toprecette.jpg') {
        return NULL;
    }
    return $statement['RecipeImage'];
}

function get_ingredients() {
    $pdo = connectDB();
    $query = 'SELECT * FROM tingredients';
    $statement = $pdo->prepare($query);
    $statement->execute();
    $statement = $statement->fetchAll();
    return $statement;
}

function count_ingredient_recipe($idRecipe) {
    $pdo = connectDB();
    $query = 'SELECT count(idIngredient) AS RecipeNbIngredient FROM tcontains WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    return $statement;
}

function checkExist_ingredient($IngredientName) {
    $pdo = connectDB();
    $query = 'SELECT idIngredient FROM tingredients WHERE IngredientName = :IngredientName';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":IngredientName" => $IngredientName));
    $statement = $statement->fetch();
    return $statement['idIngredient'];
}

function add_ingredient($IngredientName) {
    $IngredientName = strtoupper($IngredientName); //renvoi l'ingredient en majuscule 

    $pdo = connectDB();
    $query = 'INSERT INTO tingredients (IngredientName) VALUES(:IngredientName)';
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
    $query = 'INSERT INTO tcontains (ContainsQuantity, idRecipe, idIngredient) VALUES(:ContainsQuantity, :idRecipe, :idIngredient)';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":ContainsQuantity" => $IngredientQuantity,
        ":idIngredient" => $idIngredient,
        ":idRecipe" => $idNewRecipe));
    $statement = $statement->fetch();
    return $pdo->lastInsertId();
}

function get_ingredients_recipe($idRecipe) {

    $pdo = connectDB();
    $query = 'SELECT tcontains.ContainsQuantity, tingredients.IngredientName '
            . 'FROM tcontains '
            . 'LEFT JOIN tingredients ON tingredients.idIngredient = tcontains.idIngredient '
            . 'WHERE tcontains.idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetchAll();
    return $statement;
}

function get_comments_recipe($idRecipe) {

    $pdo = connectDB();
    $query = 'SELECT tcomments.idComment, tcomments.CommentText, tcomments.CommentDate, tcomments.idUser '
            . 'FROM tcomments '
            . 'WHERE tcomments.idRecipe = :idRecipe '
            . 'ORDER BY tcomments.CommentDate DESC';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetchAll();
    return $statement;
}

function get_recipe_types() {
    $pdo = connectDB();
    $query = 'SELECT * FROM ttypes';
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

    $pdo = connectDB();
    $date = date('Y-m-d H:i:s', time()); //recupere la date et l'heure
    $query = 'INSERT INTO tcomments (CommentText, CommentNote, CommentDate, idUser, idRecipe) VALUES (:CommentText, :CommentNote, :CommentDate, :idUser, :idRecipe)';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser,
        ":idRecipe" => $idRecipe,
        ":CommentText" => $comment,
        ":CommentNote" => $note,
        ":CommentDate" => $date));
    $statement = $statement->fetch();
    return;
}

function get_users() {

    $pdo = connectDB();

    $query = 'SELECT idUser, UserEmail, UserPseudo, UserAdmin FROM tusers';
    $statement = $pdo->prepare($query);
    $statement->execute();
    $statement = $statement->fetchAll();
    return $statement;
}

function get_user($idUser) {
    $pdo = connectDB();

    $query = 'SELECT UserEmail, UserPseudo, UserAdmin FROM tusers WHERE idUser = :idUser';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return $statement;
}

function get_user_pseudo($idUser) {
    $pdo = connectDB();

    $query = 'SELECT UserPseudo FROM tusers WHERE idUser = :idUser';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return $statement['UserPseudo'];
}

function check_password($idUser, $password) {

    $pdo = connectDB();
    $query = 'SELECT UserPassword FROM tusers WHERE idUser = :idUser';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    if ($statement['UserPassword'] == $password) {
        return true;
    }
    return false;
}

function edit_user($NewPseudo, $NewEmail, $idUser) {
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
        case 1: $query = 'UPDATE tusers SET UserPseudo = :UserPseudo WHERE idUser = :idUser;';
            $statement = $pdo->prepare($query);
            $statement->execute(array(":idUser" => $idUser,
                ":UserPseudo" => $NewPseudo));
            break;

        case 2: $query = 'UPDATE tusers SET UserEmail = :UserEmail  WHERE idUser = :idUser;';
            $statement = $pdo->prepare($query);
            $statement->execute(array(":idUser" => $idUser,
                ":UserEmail" => $NewEmail));
            break;

        case 3: $query = 'UPDATE tusers SET UserPseudo = :UserPseudo, UserEmail = :UserEmail  WHERE idUser = :idUser;';
            $statement = $pdo->prepare($query);
            $statement->execute(array(":idUser" => $idUser,
                ":UserPseudo" => $NewPseudo,
                ":UserEmail" => $NewEmail));
            break;
    }


    $statement = $statement->fetch();
    return true;
}

function set_administrateur($UserAdmin, $idUser) {
    $pdo = connectDB();
    $query = 'UPDATE tusers SET UserAdmin = :UserAdmin WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser,
        ":UserAdmin" => $UserAdmin));
    $statement = $statement->fetch();
    return true;
}

function edit_user_password($idUser, $NewPassword) {

    $pdo = connectDB();
    $query = 'UPDATE tusers SET UserPassword = :UserPassword WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser,
        ":UserPassword" => $NewPassword));
    $statement = $statement->fetch();
    return true;
}

/**
 * Supprime l'utilisateur dont l'id est reçu en paramètre
 * @param type $idUser
 * @return boolean
 */
function delete_user($idUser) {
    $pdo = connectDB();

    $query = 'DELETE FROM tusers WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return true;
}

function delete_link_user_recipes($idUser) {
    $pdo = connectDB();
    $query = 'UPDATE tcomments SET idUser = "0" WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return;
}

function delete_link_user_comments($idUser) {
    $pdo = connectDB();
    $query = 'UPDATE trecipes SET idUser = "0" WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return;
}

function check_owner_recipe($idUser, $idRecipe) {

    $pdo = connectDB();
//recupere une valeur pour vérifier si l'utilisateur est propriétaire du commentaire
    $query = 'SELECT idUser FROM trecipes WHERE idRecipe = :idRecipe;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    if ($statement['idUser'] == $idUser) {
        return true;
    }
    return false;
}

function check_owner_comment($idUser, $idComment) {
    $pdo = connectDB();
//recupere une valeur pour vérifier si l'utilisateur est propriétaire du commentaire
    $query = 'SELECT idUser FROM tcomments WHERE idComment = :idComment;';
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

    $query = 'DELETE FROM tcomments WHERE idComment = :idComment';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idComment" => $idComment));
    $statement = $statement->fetch();
}

function delete_contains_recipe($idRecipe) {
    $pdo = connectDB();

    $query = 'DELETE FROM tcontains WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    return;
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

function show_avg_note_recipe($AvgNote) {
    $text = NULL;
//Affiche 5 étoile remplies ou vides selon la moyenne des notes récupére
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $AvgNote) {
            $text .= '<span class="glyphicon glyphicon-star"></span>'; //Etoile remplie
        } else {
            $text .= '<span class="glyphicon glyphicon-star-empty"></span>'; //Etoile vide
        }
    }
    return $text;
}

function delete_comment_recipe($idRecipe) {
    $pdo = connectDB();

    $query = 'DELETE FROM tcomments WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    return;
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


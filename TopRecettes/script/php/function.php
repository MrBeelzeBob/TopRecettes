<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015

Fonctions - funciton.php
-->
<?php

require_once('connectDB.php');
require_once('outilsFormulaire.php');

/**
 * Affiche un block (rouge) qui contient un message d'erreur
 * @param type $Message -> message à afficher
 */
function ShowError($Message) {
    echo '<div class="message col-sm-6 col-sm-offset-3 alert alert-dismissible alert-danger"> ';
    echo '<button type="button" class="close" data-dismiss="alert">×</button>';
    echo '<p style="text-align: center;">' . $Message . '</p>';
    echo '</div>';
}

/**
 * Affiche un block (vert) qui contient un message de succès
 * @param type $Message -> message à afficher
 */
function ShowSuccess($Message) {
    echo '<div class="message col-sm-6 col-sm-offset-3 alert alert-dismissible alert-success"> ';
    echo '<button type="button" class="close" data-dismiss="alert">×</button>';
    echo '<p style="text-align: center;">' . $Message . '</p>';
    echo '</div>';
}

/**
 * Connexion au site
 * Récupère les données de l'utilisateur dont les informations correspondent à celles reçu en paramètre
 * @param type $UserEmail -> Email utilisé pour récupérer l'utilisateur
 * @param type $UserPassword -> mot de passe utilisé pour récupérer l'utilisateur
 * @return boolean
 */
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

/**
 * Crée un nouvel utilisateur
 * @param type $UserPseudo -> Pseudo du nouvel utilisateur
 * @param type $UserEmail -> Email du nouvel utilisateur
 * @param type $UserPassword -> Mot de passe du nouvel utilisateur
 * @return boolean
 */
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
 * Récupère tous les utilisateurs présents dans la base
 * @return type -> Liste des utilisateurs
 */
function get_users() {

    $pdo = connectDB();

    $query = 'SELECT idUser, UserEmail, UserPseudo, UserAdmin FROM tusers';
    $statement = $pdo->prepare($query);
    $statement->execute();
    $statement = $statement->fetchAll();
    return $statement;
}

/**
 * Récupère les données de l'utilisateur
 * @param type $idUser -> identifiant de l'utilisateur à récupérer
 * @return type -> Retourne les données de l'utilisateur
 */ 
function get_user($idUser) {
    $pdo = connectDB();

    $query = 'SELECT UserEmail, UserPseudo, UserAdmin FROM tusers WHERE idUser = :idUser';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return $statement;
}

/**
 * Récupère le pseudo de l'utilisateur 
 * @param type $idUser -> identifiant de l'utilisateur
 * @return type -> Pseudo de l'utilisateur
 */
function get_user_pseudo($idUser) {
    $pdo = connectDB();

    $query = 'SELECT UserPseudo FROM tusers WHERE idUser = :idUser';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return $statement['UserPseudo'];
}

/**
 * Vérifie le mot de passe de l'utilisateur
 * Récupère le mot de passe de l'utilisateur
 * Vérifie si le mot de passe récuperé est pareil au mot de passe en paramètre
 * @param type $idUser -> identifiant de l'utilisateur
 * @param type $password -> mot de passe à vérifier
 * @return boolean -> pareil ou pas
 */
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

/**
 * Vérifie si le pseudo en paramètre est déjà utilisé
 * Récupère le pseudo qui correspond au pseudo en paramètre
 * Si une valeurs est récupèrée -> le pseudo est déjà utilisé
 * @param type $UserPseudo -> pseudo à vérifier
 * @return boolean -> Utilisé ou pas
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
        return true; //Existe
    }
    return false; //Existe pas
}

/**
 * Vérifie si l' email en paramètre est déjà utilisé
 * Récupère l'email qui correspond à l'emial en paramètre
 * Si une valeurs est récupérée -> l'email est déjà utilisé
 * @param type $UserEmail -> Email
 * @return boolean
 */
function CheckExist_Email($UserEmail) {
    $pdo = connectDB();
    $query = 'SELECT UserEmail FROM tusers WHERE UserEmail = :UserEmail ;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":UserEmail" => $UserEmail));
    $statement = $statement->fetch();
    if ($statement) {
        return true; //existe
    }
    return false; //existe pas
}

/**
 * Test si l'utilisateur est admin
 * Récupère le type d'utilisateur
 * si la valeur récupérée est 1 -> Administrateur
 * si la valeur récupérée est 0 -> Utilisateur  
 * @param type $idUser -> identifiant de l'utilisateur à tester
 * @return boolean
 */
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

/**
 * Modifie les données (Pseudo, Email) de l'utilisateur
 * @param type $NewPseudo -> Nouveau pseudo
 * @param type $NewEmail -> Nouvelle email
 * @param type $idUser -> Identifiant de l'utilisateur
 * @return boolean
 */
function edit_user($NewPseudo, $NewEmail, $idUser) {
    $pdo = connectDB();
    if ((!empty($NewPseudo)) AND ( empty($NewEmail))) { //test si le pseudo n'est pas vide et si l'email est vide
        $ToDo = 1; //modifie le pseudo uniquement
    }
    if ((!empty($NewEmail)) AND ( empty($NewPseudo))) { //test si l'email n'est pas vide et si le pseudo est vide
        $ToDo = 2; //modifie l'email uniquement
    }
    if ((!empty($NewPseudo)) AND (!empty($NewEmail))) { //test si le pseudo et l' email ne sont pas vide
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


/**
 * Modifie le type de l'utilisateur dont l'identifiant est rçu en paramètre
 * @param type $UserAdmin -> Type d'utilisateur : Administrateur (1) ou Utilisateur(0)
 * @param type $idUser -> identifiant de l'utilisateur
 * @return boolean
 */
function set_administrateur($UserAdmin, $idUser) {
    $pdo = connectDB();
    $query = 'UPDATE tusers SET UserAdmin = :UserAdmin WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser,
        ":UserAdmin" => $UserAdmin));
    $statement = $statement->fetch();
    return true;
}

/**
 * Modifie le mot de passe de l'utilisateur
 * @param type $idUser -> identifiant de l'utilisateur
 * @param type $NewPassword -> Nouveau mot de passe
 * @return boolean
 */
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
 * Supprime l'utilisateur
 * @param type $idUser -> identifiant de l'utilisateur à supprimer
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

/**
 * Récupère la liste des recettes
 * Test s'il y a un tri à éffectuer
 * Test s'il y a une recherche à efféectué
 * @param type $sort -> Définit le tri à éffectuer lors de la récupération (entre 1 et 5 ou NULL)
 * @param type $search -> Définit la recherche à éffectuer lors de la récupération (vide ou avec une valeur)
 * @param type $idUser -> Identifiant de l'utilisateur qui veut récupérer ses recettes
 * @param type $limit -> Limite de rectte à récupérer
 * @return type
 */
function get_recipes($sort, $search, $idUser, $limit) {
    $pdo = connectDB();

    $query = 'SELECT trecipes.idRecipe, trecipes.RecipeTitle, trecipes.RecipeImage, trecipes.RecipeDate, trecipes.idUser, AVG(tcomments.CommentNote) AS RecipeAVG '
            . 'FROM trecipes '
            . 'LEFT JOIN tcomments ON tcomments.idRecipe = trecipes.idRecipe ';

    //Récupère les recettes selon un tri 
    switch ($sort) {
        case NULL:
            if (!empty($search)) {
                $query .= 'WHERE trecipes.RecipeTitle REGEXP "' . $search . '" ';
            }
            $query .= 'GROUP BY trecipes.idRecipe '
                    . 'ORDER BY trecipes.RecipeTitle ';
            break;
            
        case 1:  //trier par Date (plus récentes)
            if (!empty($search)) {
                //Recherche
                $query .= 'WHERE trecipes.RecipeTitle REGEXP "' . $search . '" ';
            }
            $query .= 'GROUP BY trecipes.idRecipe '
                    . 'ORDER BY trecipes.RecipeDate DESC ';
            break;
            
        case 2://trier par Date (plus anciennes)
            if (!empty($search)) {
                //Recherche
                $query .= 'WHERE trecipes.RecipeTitle REGEXP "' . $search . '" ';
            }
            $query .= 'GROUP BY trecipes.idRecipe '
                    . 'ORDER BY trecipes.RecipeDate ASC ';
            break;
            
        case 3: //trier par meilleures notes
            if (!empty($search)) {
                //Recherche
                $query .= 'WHERE trecipes.RecipeTitle REGEXP "' . $search . '" ';
            }
            $query .= 'GROUP BY trecipes.idRecipe '
                    . 'ORDER BY RecipeAVG DESC ';
            break;
        case 4: //trier par moins bonne notes
            if (!empty($search)) {
                //Recherche
                $query .= 'WHERE trecipes.RecipeTitle REGEXP "' . $search . '" ';
            }
            $query .= 'GROUP BY trecipes.idRecipe '
                    . 'ORDER BY RecipeAVG ASC ';

            break;
            
        case 5: //trier par Auteur
            if (!empty($search)) {
                //Recherche
                $query .= 'WHERE trecipes.RecipeTitle REGEXP "' . $search . '" AND trecipes.idUser = ' . $idUser . ' ';
            } else {
                $query .= 'WHERE trecipes.idUser = ' . $idUser . ' ';
            }
            $query .= 'GROUP BY trecipes.idRecipe '
                    . 'ORDER BY RecipeTitle ';
            break;
    }//end switch

    if (!empty($limit)) {  //Ajoute une limit de recettes à récupérer
        $query .= 'Limit 4 ';
    }
    $statement = $pdo->prepare($query);
    $statement->execute();
    $statement = $statement->fetchall();

    return $statement;
}

/**
 * Récupère les données (l'id, le titre, la preparation, l'origine, 
 * la moyenne des notes, le type de recette, l'image, l'auteur)d'une recette
 * @param type $idRecipe -> Identifiant de la recette 
 * @return type
 */
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

/**
 * Ajout d'une nouvelle recette
 * Récupère l'heure actuelle
 * Test si la recette a une image -> Ajoute la recette avec l'image reçu
 * Si il n'y pas d'image reçu -> Ajoute la recette sans image
 * @param type $RecipeInfos -> Contient les données de la recette (Titre, Preparation, Origine, Type de recette, Image)
 * @param type $idUser -> Auteur de la recette
 * @return type -> retourne l'identifiant de la nouvelle recette
 */
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

/**
 * Modification d'une recette
 * @param type $idRecipe -> identifiant de la recerre à modifier
 * @param type $RecipeInfos -> Données de modifications
 * @return type
 */
function edit_recipe($idRecipe, $RecipeInfos) {

    var_dump_pre($RecipeInfos);

    $pdo = connectDB();

//Test si l'image doit aussi etre modifier
    if (!empty($RecipeInfos['RecipeImage_New']['name'])) {
        if ($RecipeInfos['RecipeImage'] == './imgRecettes/toprecette.jpg') { //Teste si l'image de la recette actuelle est celle par défaut
            $PathImage = upload($RecipeInfos['RecipeImage_New']); //upload la nouvelle image
        } else {
            unlink($RecipeInfos['RecipeImage']); //supprime l'ancienne image ajouté par l'utilisateur
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

/**
 * Supprime une recette
 * @param type $idRecipe -> identifiant de la recette à supprimer
 * @return type
 */
function delete_recipe($idRecipe) {
    $pdo = connectDB();

    $query = 'DELETE FROM trecipes WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    return;
}

/**
 * Récupère le chemin d'accès à l'image de la recette dont l'identifiant est en paramètre
 * Si le chemin récupéré correspond au chemin de l'image par défaut -> retourne false
 * Si le chemin récupéré ne correspond pas au chemin de l'image par défaut -> retourne le chemin récupéré
 * @param type $idRecipe -> identifiant de la recette
 * @return null
 */
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

/**
 * Récupère tous les ingrédients de la base
 * @return type
 */
function get_ingredients() {
    $pdo = connectDB();
    $query = 'SELECT * FROM tingredients';
    $statement = $pdo->prepare($query);
    $statement->execute();
    $statement = $statement->fetchAll();
    return $statement;
}

/**
 * Récupère le nombre d'ingrédients qui composent la recette dont l'identifiant est en paramètre
 * @param type $idRecipe -> idenfiant de la recette
 * @return type
 */
function count_ingredient_recipe($idRecipe) {
    $pdo = connectDB();
    $query = 'SELECT count(idIngredient) AS RecipeNbIngredient FROM tcontains WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    return $statement;
}

/**
 * Récupère l'identifiant de l'ingrédient recherché en paramètre
 * @param type $IngredientName -> Ingrédient recherché
 * @return type
 */
function checkExist_ingredient($IngredientName) {
    $pdo = connectDB();
    $query = 'SELECT idIngredient FROM tingredients WHERE IngredientName = :IngredientName';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":IngredientName" => $IngredientName));
    $statement = $statement->fetch();
    if($statement['idIngredient'] == NULL) {
        return false;
    }
    return $statement['idIngredient'];
}

/**
 * Ajoute un nouvel ingrédient à la base
 * @param type $IngredientName -> Nom de l'ingrédient
 * @return type
 */
function add_ingredient($IngredientName) {
    $IngredientName = strtoupper($IngredientName); //renvoi l'ingredient en majuscule 

    $pdo = connectDB();
    $query = 'INSERT INTO tingredients (IngredientName) VALUES(:IngredientName)';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":IngredientName" => $IngredientName));
    $statement = $statement->fetch();
    return $pdo->lastInsertId();
}

/**
 * Transforme un tableau de données en un tableau associatif
 * @return type -> retourne le tableau associatif
 */
function ingredients_associate() {
//TRANSFORM ARRAY IN ASSOCIATIF ARRAY FOR INGREDIENTS
    $table = get_ingredients(); //
    foreach ($table as $ingredient) {
        $table_associate[$ingredient['idIngredient']] = $ingredient['IngredientName'];
    }
    return $table_associate;
}


/**
 * Récupère tous les types de recettes
 * @return type
 */
function get_recipe_types() {
    $pdo = connectDB();
    $query = 'SELECT * FROM ttypes';
    $statement = $pdo->prepare($query);
    $statement->execute();
    $statement = $statement->fetchAll();
    return $statement;
}

/**
 * Transforme le tableau de données des types de recettes en un tableau associatif
 * @return type
 */
function recipe_types_associate() {
//TRANSFORM ARRAY IN ASSOCIATIF ARRAY FOR INGREDIENTS
    $table = get_recipe_types();
    $table_associate = array('' => 'Type de plat');
    foreach ($table as $type) {
        $table_associate[$type['idType']] = $type['TypeName'];
    }
    return $table_associate;
}

/**
 * Ajoute un contenu d'une recette
 * Le contenu est composé de : L'identifiant d'un ingrédient, la quantité de l'ingédient et l'identifiant de la recette
 * @param type $idIngredient -> Identifiant de l'ingédients
 * @param type $IngredientQuantity -> Quantité d'ingrédient
 * @param type $idNewRecipe -> identifiant de la recette qui est composé de ce nouveau contenu
 * @return type
 */
function add_contains($idIngredient, $IngredientQuantity, $idRecipe) {
    $pdo = connectDB();
    $query = 'INSERT INTO tcontains (ContainsQuantity, idRecipe, idIngredient) '
            . 'VALUES(:ContainsQuantity, :idRecipe, :idIngredient)';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":ContainsQuantity" => $IngredientQuantity,
        ":idIngredient" => $idIngredient,
        ":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    return;
}

/**
 * Récupère les contenus de la recette en paramètre
 * Le contenu est composé de : L'identifiant d'un ingrédient, la quantité de l'ingédient et l'identifiant de la recette
 * @param type $idRecipe -> identifiant de la recette
 * @return type
 */
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

/**
 * Récupère les commentaires postés sur une recette
 * @param type $idRecipe -> identifiant de la recette
 * @return type
 */
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


/**
 * Ajoute un commentaire
 * @param type $idUser -> Identifiant de l'utilisateur qui poste le commentaitre
 * @param type $idRecipe -> Identifiant de la recette sur laquelle le commentaire est posté
 * @param type $comment -> Le commentaire
 * @param type $note -> La note
 * @return type
 */
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

/**
 * Supprime les commentaires posté par l'utilisateur dont l'identifiant est en paramètre
 * @param type $idUser -> identifiant de l'utilisateur 
 * @return type
 */
function delete_user_comments($idUser) {
    $pdo = connectDB();
    $query = 'DELETE FROM tcomments WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return;
}

/**
 * Supprime les liens entre l'utilisateur et les commentaires qu'il a posté
 * @param type $idUser -> identifiant de l'utilisateur
 * @return type
 */
function delete_link_user_recipes($idUser) {
    $pdo = connectDB();
    $query = 'UPDATE trecipes SET idUser = "0" WHERE idUser = :idUser;';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idUser" => $idUser));
    $statement = $statement->fetch();
    return;
}

/**
 * Vérifie si l'utilisateur est le propriétaire de la recette
 * Récupère l'identifiant de l'utilisateur qui à écrit la recette en paramètre
 * Vérifie si l'identifiant récuperé est pareil que l'identifiant en peremètre
 * @param type $idUser -> identifiant de l'utilisateur
 * @param type $idRecipe -> identifiant de la recette
 * @return boolean -> Propriétaire ou pas
 */
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

/**
 * Vérifie si l'utilisateur est le propriétraire du commentaire
 * Récupère l'identifiant de l'utilisateur qui à écrit le commentaire en paramètre
 * Vérifie si l'identifiant récuperé est pareil que l'identifiant en peremètre
 * @param type $idUser -> identifiant de l'utilisateur
 * @param type $idComment -> Identifiant du commentaire
 * @return boolean -> Propriétaire ou pas
 */
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

/**
 * Supprime un commentaire de la base
 * @param type $idComment -> Identifiant du commentaire à supprimé
 */
function delete_comment($idComment) {
    $pdo = connectDB();

    $query = 'DELETE FROM tcomments WHERE idComment = :idComment';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idComment" => $idComment));
    $statement = $statement->fetch();
    return;
}

/**
 * Supprime les associations entre une recette et les ingrédients, quantités qui la compose.
 * @param type $idRecipe -> identifiant de la recette 
 * @return type
 */
function delete_contains_recipe($idRecipe) {
    $pdo = connectDB();

    $query = 'DELETE FROM tcontains WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    return;
}

/**
 * Affiche 5 étoiles vides et/ou remplies 
 * L'affichage des étoiles dépend de la moyenne reçu en peremètre
 * @param type $AvgNote -> moyenne des notes d'une recette
 * @return string
 */
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

/**
 * Supprime les commentaires, notes liés à la recette en paramètre
 * @param type $idRecipe -> identifiant de la recette 
 * @return type
 */
function delete_comment_recipe($idRecipe) {
    $pdo = connectDB();

    $query = 'DELETE FROM tcomments WHERE idRecipe = :idRecipe';
    $statement = $pdo->prepare($query);
    $statement->execute(array(":idRecipe" => $idRecipe));
    $statement = $statement->fetch();
    return;
}

/**
 * upload les images dans le dossier imgRecettes
 * L'image est traitée afin de changer son nom
 * Son nouveau nom est définit par la fonction uniqid()
 * @param type $file Image à uploader
 * @return string -> emplacement ou l'image à été uploadé
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


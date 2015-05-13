<!--
Auteur      : Cedric Dos Reis
Sujet       : TopRecettes - TPI 2015

Outils de formulaire - outilsFormulaire.php
-->
<?php

/**
 * Permet de créer un Select (formulaire) à partir d'un tableau associatif
 * @param type $name nom du select
 * @param type $liste tableau associatif
 * @param type $courant
 * @param type $required
 * @return string
 */
function Select($name, $liste, $courant, $required) {
    //CRÉE UN SELECT AVEC DES OPTIONS

    if ($required) {
        $text = '<select id="' . $name . '" name="' . $name . '" class="form-control" required="">';
    } else {
        $text = '<select id="' . $name . '" name="' . $name . '" class="form-control">';
    }

    foreach ($liste as $option => $val)
        if ($option == $courant)
            $text .= '<option value="' . $option . '" selected=\"selected\">' . $val . '</option>';
        else
            $text .= '<option value="' . $option . '">' . $val . '</option>';
    $text .= '</select>';
    return $text;
}

/**
 * Permet de créer une DataList (formulaire) à partir d'un tableau associatif
 * @param type $name nom du dataliste
 * @param type $liste tableau associatif
 * @param type $courant 
 * @return string
 */
function DataList($name, $liste) {
    //CREATE A DATALIST WITH OPTIONS
    $text = '<datalist  id="' . $name . '" name="' . $name;

    $text .= '>';

    foreach ($liste as $option => $val)
        $text .= '<option value="' . $val . '">';
    $text .= '</datalist>';
    return $text;
}

?>
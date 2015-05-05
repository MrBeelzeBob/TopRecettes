<?php

/**
 * Permet de créer un Select (formulaire) à partir d'un tableau associatif
 * @param type $name nom du select
 * @param type $liste tableau associatif
 * @param type $courant 
 * @return string
 */
function Select($name, $liste, $courant) {
    //CREATE A SELECT WITH OPTIONS
    $text = '<select id="' . $name . '" name="' . $name . '" class="form-control" required=""';

    $text .= '>';

    foreach ($liste as $option => $val)
        if ($option == $courant)
            $text .= '<option value="' . $option . '" selected=\"selected\">' . $val . '</option>';
        else
            $text .= '<option value="' . $option . '">' . $val . '</option>';
    $text .= '</select>';
    return $text;
}



/**
 * Construit une série de cases à cocher basée sur le tableau associatif $liste,
 * cochant l'ensemble de éléments cochés signalé comme tel dans le tableaus $checked
 * et ajoute les éventuels attributs
 * @param string $name nom des champs
 * @param array $liste liste des options
 * @param array $checked liste des options sélectionnées
 * @return array tableau d'élements html input/checkbox prêts à l'emploi
 */
function Checkboxes($name, $liste, $checked) {
    $cbs = array();
    $checkthis = NULL;
    foreach ($liste as $id => $texte) {
        if ($checked) {
            $checkthis = (in_array($id, $checked)) ? 'checked="checked"' : '';
        }

        $cb = '<label class="checkbox-inline">' .
                '<input type="checkbox" name="' . $name . '[]" value="' . $id .
                '" id="' . $name . $id . '" ' . $checkthis . ' />' . $texte .
                '</label>';
        $cbs[] = $cb;
    }
    return $cbs;
}
?>
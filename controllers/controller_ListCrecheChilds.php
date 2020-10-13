<?php
use CrecheCalendar\Child;
use CrecheCalendar\RespLegal;

require '../config/constRegex.php';
$error = [];

$child = new Child();
$respLegal = new RespLegal();


/**
 * update child
 */
$btnUpdate = filter_input(INPUT_POST, 'updateChildBtn', FILTER_SANITIZE_SPECIAL_CHARS);
if ($btnUpdate === 'modifier') {
    $submitUpdateChildId = filter_input(INPUT_POST, 'InputChildId', FILTER_SANITIZE_NUMBER_INT, FILTER_VALIDATE_INT);
    $submitUpdateChildFname = filter_input(INPUT_POST, 'InputChild_fName', FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => NAME_REGEX)));
    $submitUpdateChildLname = filter_input(INPUT_POST, 'InputChild_lName', FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => NAME_REGEX)));
    $submitUpdateDateOfBirth = filter_input(INPUT_POST, 'InputDateOfBirth', FILTER_SANITIZE_NUMBER_INT, FILTER_VALIDATE_INT);

    // vérifie le prénom de l'enfant
    if (!$submitUpdateChildFname) {
        $error['childFirstName'] = 'Le prénom de l\'enfant ne respecte pas le format attendu (A-z  \'.-)';
    }
    // vérifie le nom de l'enfant
    if (!$submitUpdateChildLname) {
        $error['childLirstName'] = 'Le nom de l\'enfant ne respecte pas le format attendu (A-z  \'.-)';
    }
    // On check la validité de la date de naissance de l'enfant
    // on défini un message en cas d'erreur
    if (!empty($submitUpdateDateOfBirth)) {
        $arrayChildDateOfBirth = explode('-', $submitUpdateDateOfBirth);
        if (!checkdate($arrayChildDateOfBirth[1], $arrayChildDateOfBirth[2], $arrayChildDateOfBirth[0])) {
            $error['dateOfBirth'] = 'Date de naissance invalide';
        }
    }
    if (empty($submitUpdateDateOfBirth)) {
        $error['dateOfBirth'] = 'Veuillez renseigner la date de naissance de l\'enfant';
    }


    if (count($error) === 0) {
        $testReqUpdateChild = $child->updateChildInfos($submitUpdateChildId, $submitUpdateChildFname, $submitUpdateChildLname, $submitUpdateDateOfBirth);
    }

}

/**
 * delete child
 */
$btnDelete = filter_input(INPUT_POST, 'deleteChildBtn', FILTER_SANITIZE_SPECIAL_CHARS);

if ($btnDelete === 'Supprimer') {
    // efface un enfant de la base de donnée si son id est passé via $_POST
    $submitDeleteChild = filter_input(INPUT_POST, 'InputChildId', FILTER_SANITIZE_NUMBER_INT, FILTER_VALIDATE_INT);
    $getRespLegForChild = $respLegal->getRespLegIdForChildId($submitDeleteChild);
    $submitedParentId = filter_var($getRespLegForChild['parent_id'], FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);


    if (!empty($submitDeleteChild)) {

        $countRespLegalForChild = $respLegal->countChildForRespLeg($submitedParentId);
        $countRespLegalForChildInt = filter_var($countRespLegalForChild['COUNT(*)'], FILTER_VALIDATE_INT, FILTER_SANITIZE_NUMBER_INT);
        $testDeleteChild = $child->deleteChild($submitDeleteChild);
        if ($countRespLegalForChildInt <= 1 && $testDeleteChild) {
            $testDeleteRespLeg = $respLegal->deleteRespLeg($submitedParentId);
        }
    }
}

/**
 * Définie message d'erreur si il y en a
 */
if (isset($error)) {
    $messageError = '';
    foreach ($error as $key => $value) {
        $messageError .=  $value . '<br>';
    }
}

// utilisé pour l'affichage
// récupère la liste des enfants de toute la crèche sélectionné
//  si aucune section n'est sélectionné
if (isset($selectedCrecheId) && $selectedCrecheId != null) {
    $arrayChilds = $child->getChilds($selectedCrecheId, $selectedCrecheSectionId);
}
// utilisé pour l'affichage
// récupère la liste des enfants de la
// section sélectionné
if (isset($selectedCrecheId) && $selectedCrecheSectionId == null) {
    $arrayChilds = $child->getChilds($selectedCrecheId);
}
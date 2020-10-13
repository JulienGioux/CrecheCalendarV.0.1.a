<?php

use CrecheCalendar\UserGender;
use CrecheCalendar\RespLegal;
use CrecheCalendar\Child;


require '../config/constRegex.php';


//Initialisation des erreurs
$error = [];
$registerRespLegSuccess = false;
$registerChildSuccess = false;

//instancie les objets nécéssaires
$userGender = new UserGender();
$respLegal = new RespLegal();
$child = new Child();

// envoie une erreur si aucune section n'est sélectionné
if ($selectedCrecheSectionId === null) {
    $error['selectedSection'] = 'Vous devez créer et sélectionner une section avant d\'ajouter un enfant';
}

//cré un tableau avec les responsables légaux déjà enregistrés pour la crèche sélectionné
$arrayRespLegForCreche = $respLegal->getRespLegForCrecheID($selectedCrecheId);

//cré un tableau avec tous les genre possible
$userGendersArray = $userGender->getGenders();

////////////////////////////////////////////////
// Nettoie les entrées utilisateurs par sécurité
// Récupère la valeur du champ caché pour connaitre l'onglet actif
///////////////////////////////////////////////////////////////////
$activeTabs = filter_input(INPUT_POST, 'selectedTab', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$isSubmit = filter_input(INPUT_POST, 'formCreateChildSubmit', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_NULL_ON_FAILURE);
$pwd1 = filter_input(INPUT_POST, 'formCreateChild_LegalRespPwd1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pwd2 = filter_input(INPUT_POST, 'formCreateChild_LegalRespPwd2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$respLegEmail = filter_input(INPUT_POST, 'formCreateChild_LegalRespUserEmail', FILTER_SANITIZE_EMAIL);
$respLegFname = filter_input(INPUT_POST, 'formCreateChild_LegalRespfName', FILTER_SANITIZE_STRING);
$respLegLname = filter_input(INPUT_POST, 'formCreateChild_LegalResplName', FILTER_SANITIZE_STRING);
$respLegPhone = filter_input(INPUT_POST, 'formCreateChild_LegalRespPhone', FILTER_SANITIZE_NUMBER_INT);
$respLegalGender = filter_input(INPUT_POST, 'formCreateChild_LegalRespGender', FILTER_SANITIZE_NUMBER_INT);

$selectedRespLeg = filter_input(INPUT_POST, 'selectedRespLeg', FILTER_SANITIZE_NUMBER_INT);

$childGender = filter_input(INPUT_POST, 'formCreateChildGender', FILTER_SANITIZE_NUMBER_INT);
$childFname = filter_input(INPUT_POST, 'formCreateChildfName', FILTER_SANITIZE_STRING);
$childLname = filter_input(INPUT_POST, 'formCreateChildlName', FILTER_SANITIZE_STRING);
$childDateOfBirth = filter_input(INPUT_POST, 'dateOfBirdth', FILTER_SANITIZE_NUMBER_INT);

//////////////////////////////////////////////////////////////////////////////////////////
/// Si le formulaire a été soumis et qu'un responsable légale a besoin d'être ajouté
/// fait les vérififications nécéssaires sur les champs
////////////////////////////////////////////////////////////////////////////////////////

if ($isSubmit != false && $activeTabs === 'addRespLeg') {
    // On check la validité du mail du responsable légal
    // on défini un message en cas d'erreur
    if (filter_var($respLegEmail, FILTER_VALIDATE_EMAIL)) {
        if ($respLegal->verifyMailExist($respLegEmail, '')) {
            $error['userEmail'] = 'Le mail " ' . $respLegEmail . ' " existe déja';
        }
    } elseif (empty($respLegEmail)) {
        $error['userEmail'] = 'Veuillez Renseigner l\'email';
    } else {
        $error['userEmail'] = 'Mauvais Format d\'email';
    }


    // On check la validité du prénom du responsable légal
    // on défini un message en cas d'erreur
    if (!filter_var($respLegFname, FILTER_VALIDATE_REGEXP,
                    array("options" => array("regexp" => NAME_REGEX)))) {
        $error['LegalRespfName'] = 'Mauvais format : prénom du responsable légal';
        if (empty($respLegFname)) {
            $error['LegalRespfName'] = 'Veuillez renseigner le prénom du responsable légal';
        }
    }

    // On check la validité du nom du responsable légal
    // on défini un message en cas d'erreur
    if (!filter_var($respLegLname, FILTER_VALIDATE_REGEXP,
                    array("options" => array("regexp" => NAME_REGEX)))) {
        $error['LegalResplName'] = 'Mauvais format : nom du responsable légal';
        if (empty($respLegLname)) {
            $error['LegalResplName'] = 'Veuillez renseigner le nom du responsable légal';
        }
    }

    // On check la validité du numéro de tel du responsable légal
    // on défini un message en cas d'erreur
    if (!filter_var($respLegPhone, FILTER_VALIDATE_REGEXP,
                    array("options" => array("regexp" => PHONE_FR_REGEX)))) {
        $error['userPhone'] = 'Numéro de téléphone invalide';
        if (empty($respLegPhone)) {
            $error['userPhone'] = 'Veuillez Renseigner le numéro de téléphone';
        }
    }

    // On check la validité des passwords du responsable légal
    // on défini un message en cas d'erreur
    if (!filter_input(INPUT_POST, 'formCreateChild_LegalRespPwd1', FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => PWD_REGEX]])) {
        $error['Pwd1'] = 'Mauvais Format: password';
    }
    if (empty($pwd1)) {
        $error['Pwd1'] = 'Veuillez Renseigner le mot de passe';
    }
    if (!filter_input(INPUT_POST, 'formCreateChild_LegalRespPwd2', FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => PWD_REGEX]])) {
        $error['Pwd2'] = 'Mauvais Format: vérifier password';
    }
    if (empty($pwd2)) {
        $error['Pwd2'] = 'Veuillez vérifier le mot de passe';
    }
    if ($pwd1 != $pwd2) {
        $error['Pwd2'] = 'Les mots de passe ne sont pas identiques';
    }
    if (!isset($error['Pwd1'], $error['Pwd2']) && $pwd1 == $pwd2) {
        $pwd1 = password_hash($pwd1, PASSWORD_DEFAULT);
    }

    // On check la validité du genre du responsable légal
    // on défini un message en cas d'erreur
    if (isset($respLegalGender)) {
        foreach ($userGendersArray as $key => $value) {
            if ($value['gender_id'] == $respLegalGender) {
                $testGenderExist = true;
                break;
            }
            $testGenderExist = false;
        }
        if (!$testGenderExist) {
            $error['respLegalGender'] = 'Genre Responsable Légal: Cette valeur n\'est pas accépté';
        }
    }
}


if ($isSubmit != false) {
// On check la validité du genre de l'enfant
// on défini un message en cas d'erreur
    if (isset($childGender)) {
        foreach ($userGendersArray as $key => $value) {
            if ($value['gender_id'] == $childGender) {
                $testGenderExist = true;
                break;
            }
            $testGenderExist = false;
        }
        if (!$testGenderExist) {
            $error['childGender'] = 'Genre enfant: Cette valeur n\'est pas accépté';
        }
    }
// On check la validité du prénom de l'enfant
// on défini un message en cas d'erreur
    if (!filter_var($childFname, FILTER_VALIDATE_REGEXP,
                    array("options" => array("regexp" => NAME_REGEX)))) {
        $error['childfName'] = 'Mauvais format : Prénom de l\'enfant';
        if (empty($respLegFname)) {
            $error['childfName'] = 'Veuillez renseigner le prénom de l\'enfant';
        }
    }


// On check la validité du nom de l'enfant
// on défini un message en cas d'erreur
    if (!filter_var($childLname, FILTER_VALIDATE_REGEXP,
                    array("options" => array("regexp" => NAME_REGEX)))) {
        $error['childlName'] = 'Mauvais format : Nom de l\'enfant';
        if (empty($respLegFname)) {
            $error['childlName'] = 'Veuillez renseigner le nom de l\'enfant';
        }
    }

// On check la validité du nom de l'enfant
// on défini un message en cas d'erreur
    if (!empty($childDateOfBirth)) {
        $arrayChildDateOfBirth = explode('-', $childDateOfBirth);
        if (!checkdate($arrayChildDateOfBirth[1], $arrayChildDateOfBirth[2], $arrayChildDateOfBirth[0])) {
            $error['dateOfBirth'] = 'Date de naissance invalide';
        }
    }
    if (empty($childDateOfBirth)) {
        $error['dateOfBirth'] = 'Veuillez renseigner la date de naissance de l\'enfant';
    }
}

// Si au submit avec bouton "ajouter" et onglet actif "ajout de responsable légal" et pas d'erreur,
// on ajoute le responsable légal et l'enfant dans la base de donnée.
if ($isSubmit != false && $activeTabs === 'addRespLeg' && count($error) === 0) {


    $respLegal->createRespLeg($respLegFname, $respLegLname, $respLegPhone, $pwd1, $respLegEmail, $respLegalGender);
    $registerRespLegSuccess = true;

    $lastRespLegalId = $respLegal->bdd->lastInsertId();


    $child->createChild($childFname, $childLname, $childDateOfBirth, $lastRespLegalId, $selectedCrecheSectionId, $selectedCrecheId, $childGender);
    $registerChildSuccess = true;
}


// On check la validité de l'id du responsable légal du selecteur
// on défini un message en cas d'erreur
if (($isSubmit != false && $activeTabs === 'getRespLeg')) {
    if (!filter_var($selectedRespLeg, FILTER_VALIDATE_INT)) {
        $error['selectedRespLeg'] = 'Veuillez séléctionner un responsable légal valide !';
    }
}
// Si au submit avec bouton "ajouter" et onglet actif "sélectionner responsable légal" et pas d'erreur,
// on ajoute l'enfant dans la base de donnée en renseignant l'id du responsable légal.
if ($isSubmit != false && $activeTabs === 'getRespLeg' && count($error) === 0) {
    $createChild = $child->createChild($childFname, $childLname, $childDateOfBirth, $selectedRespLeg, $selectedCrecheSectionId, $selectedCrecheId, $childGender);
    $registerChildSuccess = $createChild;
}




if ($registerChildSuccess === true) {
    $successMsg = 'L\'enfant ' . $childFname . ' ' . $childLname . ' a bien été enregistré.';
    $childGender = $childFname = $childLname = $childDateOfBirth = '';
}

if ($registerRespLegSuccess === true) {
    $successMsg .= '<br>L\'utilisateur ' . $respLegFname . ' ' . $respLegLname . ' a bien été enregistré.';
    $respLegEmail = $respLegFname = $respLegLname = $respLegPhone = $respLegalGender = '';
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

<?php

use CrecheCalendar\Creche;

require '../config/constRegex.php';

$creche = new Creche();
/**
 * @array $error Liste les messages d'erreur dans un tableau associatif
 */
$error = [];


/**
 * Vérification des données de formulaire
 */

/**
 * Vérification du nom de la crèche.
 *
 * @var bool|null|string $crecheName Le nom de la crèche, null si vide, false si invalide.
 */

if (empty($_POST['crecheName'])) {
$error['crecheName'] = 'Veuillez renseigner le nom de la crèche';
} else {
    $crecheName = filter_input(INPUT_POST, 'crecheName', FILTER_VALIDATE_REGEXP,
        array("options"=>array("regexp"=>NAME_REGEX)));
    $crecheName = filter_var($crecheName, FILTER_SANITIZE_SPECIAL_CHARS);
    if (!$crecheName) {
        $error['crecheName'] = 'Le format du nom de la crèche n\'est pas conforme';
    }
}

/**
 * Vérification de l'adresse mail de la crèche.
 *
 * @var bool|null|string $crecheEmail Le nom de la crèche, null si vide, false si invalide.
 */
$crecheEmail = filter_input(INPUT_POST, 'crecheEmail', FILTER_SANITIZE_EMAIL);
if (empty($crecheEmail)) {
    $error['crecheEmail'] = 'Veuillez Renseigner l\'adresse Email de la crèche';
} else {
    $crecheEmail = filter_var($crecheEmail, FILTER_VALIDATE_EMAIL);
    if (!$crecheEmail) {
        $error['crecheEmail'] = 'Mauvais Format d\'e-mail';
    } else {
        if ($creche->verifyMailExist($crecheEmail)) {
            $error['crecheEmail'] = 'Ce mail est déjà attribué à une crèche';
        }
    }
}

/**
 * Vérification du format de numéro tél (fr)
 *
 */
if (isset($_POST['crechePhone'])) {
    $crechePhone = filter_input(INPUT_POST, 'crechePhone', FILTER_VALIDATE_REGEXP,
        array("options"=>array("regexp"=>PHONE_FR_REGEX)));
    $crechePhone = filter_input(INPUT_POST, 'crechePhone', FILTER_SANITIZE_NUMBER_INT);
    if (!$crechePhone) {
        $error['Tél.'] = 'Le format du numéro de téléphone n\'est pas valide';
    }
}
if (empty($_POST['crechePhone'])) {
        $error['Tél.'] = 'Veuillez Renseigner le numéro de téléphone';
}


/**
 * Vérification du format d'adresse
 */
$crecheAddress1 = filter_input(INPUT_POST, 'crecheAddress1', FILTER_SANITIZE_SPECIAL_CHARS);
if (empty($crecheAddress1)) {
    $error['Address1'] = 'Veuillez Renseigner l\'adresse de la crèche';
} elseif (!filter_input(INPUT_POST, 'crecheAddress1', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>ADDRESS_REGEX)))) {
    $error['Address1'] = 'Format d\'adresse non valide';
}

/**
 * Vérification du format d'adresse complémentaire
 */
$crecheAddress2 = filter_input(INPUT_POST, 'crecheAddress2', FILTER_SANITIZE_SPECIAL_CHARS);
if (!empty($crecheAddress2) && !filter_input(INPUT_POST, 'crecheAddress2', FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>ADDRESS_REGEX)))) {
    $error['Address2'] = 'Format d\'adresse complémentaire non valide';
}

/**
 * Vérification du code postal
 *
 */
if (isset($_POST['crecheCodePost'])) {
    $crecheCodePost = filter_input(INPUT_POST, 'crecheCodePost', FILTER_VALIDATE_REGEXP,
        array("options"=>array("regexp"=>NIC_CODE_POST_REGEX)));
    if (!$crecheCodePost) {
        $error['crecheCodePost'] = 'Format de Code postal non valide';
    }
    $crecheCodePost = filter_var($crecheCodePost, FILTER_SANITIZE_NUMBER_INT);
}
if (empty($_POST['crecheCodePost'])) {
    $error['crecheCodePost'] = 'Veuillez Renseigner le code postal';
}

/**
 * Vérification du nom de la commune
 */
$crecheCity = filter_input(INPUT_POST, 'crecheCity', FILTER_SANITIZE_SPECIAL_CHARS);
if (empty($crecheCity)) {
    $error['crecheCity'] = 'Veuillez renseigner le nom de la commune';
} else {
    $crecheCity = filter_var($crecheCity, FILTER_VALIDATE_REGEXP,
        array("options"=>array("regexp"=>NAME_REGEX)));
    if (!$crecheCity) {
        $error['crecheCity'] = 'Le format de nom de commune n\'est pas valide';
    }
}

/**
 * Vérification du numéro de siren
 */
if (isset($_POST['crecheSiren'])) {

    $crecheSiren = filter_input(INPUT_POST, 'crecheSiren', FILTER_SANITIZE_NUMBER_INT);

    $isSiren = $creche->is_siren($_POST['crecheSiren']);
    if ($isSiren === 1) {
        $error['crecheSiren'] = 'Le SIREN doit contenir 9 caractères';
    } elseif ($isSiren === 2) {
        $error['crecheSiren'] = 'Le SIREN ne doit contenir que des chiffres';
    } elseif ($isSiren === false) {
        $error['crecheSiren'] = 'Numero de SIREN invalide';
    }
}
if (empty($_POST['crecheSiren'])) {
    $error['crecheSiren'] = 'Veuillez Renseigner le numéro SIREN';
}

/**
 * Vérification du numéro NIC
 */
if (isset($_POST['crecheNic']) && !empty($_POST['crecheNic'])){
     if (isset($crecheSiren)) {
        $crecheNic = filter_input(INPUT_POST, 'crecheNic', FILTER_SANITIZE_NUMBER_INT);
        $isSiret = $creche->is_siret($crecheSiren, $crecheNic);
        if (!$isSiret) {
            if(isset($error['crecheSiren'])) {
                $error['crecheNic'] = 'Veuillez corriger votre numéro de SIREN pour valider le NIC';
            } else {
                $error['crecheNic'] = 'Veuillez corriger votre numéro NIC';
            }
        }
    }
}


/**
 * Définie message d'erreur si il y en a
 */
if (isset($error) && isset($_POST['formCreateCreche'])) {
    $messageError = '';
    foreach ($error as $key => $value) {
        $messageError .=  $value . '<br>';
    }
}

/**
 * Ajoute une crèche lié au modérateur en cours de session à la base de donnée
 */
if (isset($_POST['formCreateCreche']) && count($error) == 0) {

  $creche->createCreche($_SESSION['auth']['id'], $crecheName, $crecheEmail, $crechePhone, $crecheAddress1, $crecheAddress2, $crecheCodePost, $crecheCity, $crecheSiren, $crecheNic);
  $_SESSION['RegisterCrecheSuccess'] = true;
    //Met à jour la liste des sections de crèche après l'ajout
    $arrayCreches = $creche->getCrechesIdByEmployeeId($_SESSION['auth']['id']);
} else {
    if (isset($_POST['formCreateCrecheManager'])) {
        $messageError .= 'Erreur : Il y a eu un problème lors de l\'enregistrement de votre creche';
    } else {
        unset($error);
    }
}

/**
 * En cas de succès défini un message pour en informer l'utilisateur.
 *
 */
if (isset($_SESSION['RegisterCrecheSuccess']) && $_SESSION['RegisterCrecheSuccess']) {
    $successMsg = 'La crèche a été ajouté. 
                <br>Vous pouvez la sélectionner et l\'administrer via le menu principal.';
    unset($messageError);
    $_SESSION['RegisterCrecheSuccess'] = null;
    unset($_SESSION['RegisterCrecheSuccess']);
}
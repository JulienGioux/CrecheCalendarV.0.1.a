<?php
use CrecheCalendar\CrecheSection;

require '../config/constRegex.php';
$error = [];

if (isset($_POST['formCreateSection']) && is_array($arrayCrecheSection)) {
    foreach ($arrayCrecheSection as $sectionItem) {
        $arrayCrecheSectionById[$sectionItem['section_id']] = $sectionItem['section_Name'];
    }
    if (in_array(htmlspecialchars($_POST['crecheSection']), $arrayCrecheSectionById)) {
        $error['sectionName'] = 'Ce nom de section existe déjà';
    }
}



if (isset($_POST['formCreateSection'], $selectedCrecheId) && (count($error) === 0)) {
    $newCrecheSection = htmlspecialchars($_POST['crecheSection']);
    $crecheSection->createSection($newCrecheSection, $selectedCrecheId);
    $_SESSION['RegisterSectionSuccess'] = true;
    //Met à jour la liste des sections de crèche après l'ajout
    $arrayCrecheSection = $crecheSection->getAllSectionsByCrecheId($selectedCrecheId);
} elseif (isset($_POST['formCreateSection'])) {
    $messageError = 'Erreur : il y a eu un problème lors de l\'enregistrement de la section';
};

/**
 * Vérifie qu'au moins une crèche existe et est séléctionné
 *
 */
if (isset($selectedCrecheId)) {
    $crecheName = $creche->getCrecheNameById($selectedCrecheId);
} else {
    $crecheName = null;
}



/**
 * Définie message d'erreur si il y en a
 */
if (isset($error) && isset($_POST['formCreateSection'])) {
    $messageError = '';
    foreach ($error as $key => $value) {
        $messageError .=  $value . '<br>';
    }
}

/**
 * En cas de succès défini un message pour en informer l'utilisateur.
 *
 */
if (isset($_SESSION['RegisterSectionSuccess']) && $_SESSION['RegisterSectionSuccess']) {
    $successMsg = 'Une nouvelle section a été créé. 
                <br>Vous pouvez la selectionner et l\'administrer via le menu principal.';
    unset($messageError);
    $_SESSION['RegisterSectionSuccess'] = null;
    unset($_SESSION['RegisterSectionSuccess']);
}

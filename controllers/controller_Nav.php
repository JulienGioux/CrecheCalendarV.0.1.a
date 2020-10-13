<?php

use CrecheCalendar\Creche;
use CrecheCalendar\CrecheSection;
$creche = new Creche();
$crecheSection = new CrecheSection();
/**
 * Cas employé / modérateur
 */
if (isset($_SESSION['auth']['id'])
    && (($_SESSION['auth']['role'] === 'Modérateur') || ($_SESSION['auth']['role'] === 'Employé'))) {
    /**
     * Liste les crèches associées au compte utilisateur et défini la séléction actuelle
     */

    $arrayCreches = $creche->getCrechesIdByEmployeeId($_SESSION['auth']['id']);
    if (filter_input(INPUT_POST, 'selectedCreche', FILTER_VALIDATE_INT)) {
        $selectedCrecheId = filter_input(INPUT_POST, 'selectedCreche', FILTER_SANITIZE_NUMBER_INT);
        $_SESSION['UserChoices']['selectedCrecheId'] = $selectedCrecheId;
    } elseif (isset($_SESSION['UserChoices']['selectedCrecheId'])) {
        $selectedCrecheId = $_SESSION['UserChoices']['selectedCrecheId'];
    }
    if (is_array($arrayCreches) && count($arrayCreches) > 0) {
            foreach ($arrayCreches as $crecheItem) {
                $arrayCrecheById[$crecheItem['creche_id']] = $crecheItem['crecheName'];
            }
            if (isset($selectedCrecheId) && array_key_exists($selectedCrecheId, $arrayCrecheById)) {
                $_SESSION['UserChoices']['selectedCrecheId'] = intval($selectedCrecheId);
            } else {
                $_SESSION['UserChoices']['selectedCrecheId'] = $selectedCrecheId
                    = intval(array_key_first($arrayCrecheById));
            }
    } else {
        unset($_SESSION['UserChoices']['selectedCrecheSectionId'], $selectedCrecheSectionId);
    }

    $selectedCrecheId = $_SESSION['UserChoices']['selectedCrecheId'] ?? null;


    /**
     * Liste les sections associées à la crèche sélectionnée et définie la séléction actuelle
     */

    $arrayCrecheSection = $crecheSection->getAllSectionsByCrecheId($selectedCrecheId);


    if (filter_input(INPUT_POST, 'selectedCrecheSection',FILTER_VALIDATE_INT)) {
        $selectedCrecheSectionId = filter_input(INPUT_POST, 'selectedCrecheSection',
            FILTER_SANITIZE_NUMBER_INT);
    } elseif (isset($_SESSION['UserChoices']['selectedCrecheSectionId'])) {
        $selectedCrecheSectionId = $_SESSION['UserChoices']['selectedCrecheSectionId'];
    }
    if (is_array($arrayCrecheSection) && count($arrayCrecheSection) > 0) {
        foreach ($arrayCrecheSection as $sectionItem) {
            $arrayCrecheSectionById[$sectionItem['section_id']] = $sectionItem['section_Name'];
        }
        if (isset($selectedCrecheSectionId) && array_key_exists($selectedCrecheSectionId, $arrayCrecheSectionById)) {
            $_SESSION['UserChoices']['selectedCrecheSectionId'] = intval($selectedCrecheSectionId);
        } else {
            $_SESSION['UserChoices']['selectedCrecheSectionId'] = $selectedCrecheSectionId
                = intval(array_key_first($arrayCrecheSectionById));
        }
    } else {
        unset($_SESSION['UserChoices']['selectedCrecheSectionId'], $selectedCrecheSectionId);
    }
    $selectedCrecheSectionId = $_SESSION['UserChoices']['selectedCrecheSectionId'] ?? null;
}

/**
 * Cas Responsable Légal
 */

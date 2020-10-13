<?php

/**
 * Projet CrechCalendar Class Child
 *
 */
namespace CrecheCalendar;


/**
 * Cette classe définie un enfant
 */
class Child {

    private $DBase;
    private $bdd;
    /**
     * Constructeur défini la connection à la base de donnée
     * 
     * 
     */
    public function __construct() {
        try {
            $this->DBase = new ConnectBdd();
            $this->bdd = $this->DBase->connexion();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Méthode de création d'un enfant
     * 
     * @param string $childFname Prénom de l'enfant.
     * @param string $childLname Nom de l'enfant.
     * @param string $childDateOfBirth Date de naisssance de l'enfant.
     * @param int $respLegId L'id du responsable légal correspondant à la table 'parents_account'
     * @param int $sectionId L'id correspondant à la section par défaut de l'enfant dans la table 'sections'
     * @param int $crecheId L'id correspondant à la crèche de l'enfant dans la table 'crèche'
     * @param int $genderID L'id correspondant au genre de l'enfant dans la table 'genders'
     * @return boolean Renvoi true la requète a abouti, false en cas d'erreur
     */
    public function createChild($childFname, 
                                $childLname, 
                                $childDateOfBirth, 
                                $respLegId, 
                                $sectionId,
                                $crecheId,
                                $genderID): bool {
        $queryCreateChild = 'INSERT INTO `childs` (
                                `FNAME`,
                                `LNAME`, 
                                `DATEOFBIRTH`, 
                                `PARENT_ID`, 
                                `SECTION_ID`, 
                                `CRECHE_ID`, 
                                `GENDER_ID`)
                            VALUES (
                                :childFname, 
                                :childLname, 
                                :childDateOfBirth, 
                                :respLegId, 
                                :sectionID, 
                                :crecheID, 
                                :genderID)';
        try {
            $resultqueryCreateChild = $this->bdd->prepare($queryCreateChild);
            $resultqueryCreateChild->bindValue(':childFname', $childFname);
            $resultqueryCreateChild->bindValue(':childLname', $childLname);
            $resultqueryCreateChild->bindValue(':childDateOfBirth', $childDateOfBirth);
            $resultqueryCreateChild->bindValue(':respLegId', $respLegId);
            $resultqueryCreateChild->bindValue(':sectionID', $sectionId);
            $resultqueryCreateChild->bindValue(':crecheID', $crecheId);
            $resultqueryCreateChild->bindValue(':genderID', $genderID);
            $result = $resultqueryCreateChild->execute();
            if ($result) {
                return $result;
            } else {
                return false;
            }
        } catch (Exception $exc) {
            die('Erreur : ' . $exc->getMessage());
        }
    }

    /**
     * Méthode pour obtenir les infos d'un enfant
     *
     * @param int $respLegId
     * @return array Renvoi la liste des enfants associé, false en cas d'erreur
     */
    public function getChildByRespLegID(int $respLegId) : array {
        $query =
            'SELECT 
                `childs`.`parent_id`, 
                `childs`.`fName`, 
                `childs`.`lName`, 
                `childs`.`creche_id`, 
                `childs`.`section_id`, 
                `childs`.`child_id` 
            FROM `childs` 
            WHERE `childs`.`parent_id` = :respLeg ';

        try {
            $resultquery = $this->bdd->prepare($query);
            $resultquery->bindValue(':respLeg', $respLegId);
            $result = $resultquery->execute();

            if ($result) {
                return $resultquery->fetchAll();
            } else {
                return false;
            }
        } catch (Exception $exc) {
            die($exc->getMessage());
        }

    }

    /**
     * Méthode pour obtenir la liste des enfants dans une crèche, ou une section si spécifié
     * 
     * @param int $crecheId L'id de la crèche
     * @param int $sectionId L'id de la section par défaut (optionnel)
     * @return boolean|array Renvoi la liste des enfants et false en cas d'erreur
     */
    public function getChilds($crecheId, $sectionId = NULL) {

        $query = 'SELECT `childs`.`child_id`, 
                    `childs`.`fName` AS child_fName, 
                   `childs`.`lName` AS child_lName, 
                   `childs`.`dateOfBirth`, 
                   `parents_account`.`parent_id`, 
                   `parents_account`.`fName` AS respLeg_fName, 
                   `parents_account`.`lName` AS respLeg_lName, 
                   `creche`.`creche_id`, 
                   `sections`.`section_id`
                    FROM `childs`
                    LEFT JOIN `creche` ON `childs`.`creche_id` = `creche`.`creche_id`
                    LEFT JOIN `sections` ON `creche`.`creche_id` = `sections`.`creche_id` AND `childs`.`section_id` = `sections`.`section_id`
                    LEFT JOIN `parents_account` ON `parents_account`.`parent_id` = `childs`.`parent_id`
                    GROUP BY `childs`.`child_id`
                    HAVING `creche`.`creche_id` = :crecheId AND IF(:sectionId != NULL, `section_id` = :sectionId, `section_id`)';


        try {
            $resultquery = $this->bdd->prepare($query);
            $resultquery->bindValue(':crecheId', $crecheId);
            $resultquery->bindValue(':sectionId', $sectionId);


            $result = $resultquery->execute();

            if ($result) {
                return $resultquery->fetchAll();
            } else {
                return false;
            }
        } catch (Exception $exc) {
            die($exc->getMessage());
        }
    }
    
    /**
     * Méthode pour mettre à jour les infos d'un enfant
     * 
     * @param int $childId L'id de l'enfant dans la table 'childs'
     * @param string $childFname Le prénom de l'enfant
     * @param string $childLname Le nom de l'enfant
     * @param string|\Date $childDateOfBirth La date de naissance de l'enfant.
     * @return boolean TRUE en cas de succès ou FALSE si une erreur survient. 
     */
    public function updateChildInfos($childId,$childFname,$childLname,$childDateOfBirth) {
        $query = 'UPDATE `childs`
                   SET `childs`.`lName` = :childLname, 
                       `childs`.`dateOfBirth` = :dateOfBirth,
                        `childs`.`fName` = :childFname
                   WHERE `child_id` = :childId';
        try {
            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->bindValue(':childId', $childId);
            $resultQuery->bindValue(':childFname', $childFname);
            $resultQuery->bindValue(':childLname', $childLname);
            $resultQuery->bindValue(':dateOfBirth', $childDateOfBirth);
            return $resultQuery->execute();
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }   
    
    
    /**
     * Méthode de suppression d'un enfant
     * 
     * @param string|int $childID L'id de l'enfant dans la table 'childs'
     * @return boolean Renvoi true la requète a abouti, false en cas d'erreur
     */
    public function deleteChild($childID) {
        $query = 'DELETE
                    FROM `childs`
                    WHERE `childs`.`child_id` = :childID';
        try {
            $resultquery = $this->bdd->prepare($query);
            $resultquery->bindValue(':childID', $childID);
            return $resultquery->execute();
        } catch (Exception $exc) {
            die($exc->getMessage());
        }
    }
}

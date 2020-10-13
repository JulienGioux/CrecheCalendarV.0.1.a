<?php

/**
 * Projet CrechCalendar
 *
 * @package CrechCalendar
 * @version 1
 */

namespace CrecheCalendar;

use Exception;
use PDO;

/**
 * Cette classe définie le responsable légal
 */
class RespLegal extends User
{

    /**
     * Récupère les informations de l'utilisateur
     *
     * @param $userEmail
     * @return mixed|null
     */
    public function getRespLegalInfos($userEmail)
    {
        $query = 'SELECT
                    `parents_account`.`fName`, 
                    `parents_account`.`lName`, 
                    `parents_account`.`email` AS userEmail, 
                    `parents_account`.`parent_id` AS userId,
                    `genders`.`gender`
                FROM
                    `parents_account`
                LEFT JOIN `genders` ON
                    `parents_account`.`gender_id` = `genders`.`gender_id`
                WHERE
                        `parents_account`.`email` = :userEmail';
        try {
            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->bindValue(':userEmail', $userEmail);
            $resultQuery->execute();
            $resultUser = $resultQuery->fetchObject(RespLegal::class);

            return $resultUser ?: null;

        } catch (Exception $e) {
            die('Erreur2 : ' . $e->getMessage());
        }

    }

    /**
     * Méthode de création d'un Responsable Légal
     *
     * @param string $respLegFname Prénom du responsable légal
     * @param string $respLegLname Nom du responsable légal
     * @param string|int $respLegPhone Un numéro de téléphone au format français ([+33|0]612121212)
     * @param string $respLegPwd Un mot de passe chiffré
     * @param string $respLegEmail Un email valide
     * @param string|int $respLegGenderId L'id correspondant au genre de la table 'genders'
     * @return boolean Renvoi true la requète a abouti, false en cas d'erreur
     */
    public function createRespLeg($respLegFname, $respLegLname, $respLegPhone, $respLegPwd, $respLegEmail, $respLegGenderId)
    {
        $queryCreateChild = 'INSERT INTO `parents_account` (
                                `parents_account`.`fName`, 
                                `parents_account`.`LNAME`, 
                                `parents_account`.`USERPHONE`, 
                                `parents_account`.`PASSWORD`, 
                                `parents_account`.`EMAIL`, 
                                `parents_account`.`GENDER_ID`)
                            VALUES (
                                :respLegFname, 
                                :respLegLname, 
                                :respLegPhone, 
                                :respLegPwd, 
                                :respLegEmail, 
                                :respLegGenderId)';
        try {
            $resultqueryCreateChild = $this->bdd->prepare($queryCreateChild);
            $resultqueryCreateChild->bindValue(':respLegFname', $respLegFname);
            $resultqueryCreateChild->bindValue(':respLegLname', $respLegLname);
            $resultqueryCreateChild->bindValue(':respLegPhone', $respLegPhone);
            $resultqueryCreateChild->bindValue(':respLegPwd', $respLegPwd);
            $resultqueryCreateChild->bindValue(':respLegEmail', $respLegEmail);
            $resultqueryCreateChild->bindValue(':respLegGenderId', $respLegGenderId);
            return $resultqueryCreateChild->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Fonction qui retourne l'ensemble des responsables légaux pour une crèche donnée
     *
     * @param string|int $crecheId L'id correspondant à la crèche demandé dans la table 'cheches'
     * @return array|boolean Renvoi un Array avec le prénom,
     * le nom, l'adresse email et l'id de chaque responsable légale ayant un enfant dans la crèche
     * passée en paramètre.
     */
    public function getRespLegForCrecheID($crecheId)
    {
        $queryGetRespLegForCrecheID =
            'SELECT
                        `childs`.`parent_id`, 
                        `childs`.`creche_id`, 
                        `creche`.`creche_id`,
                        `parents_account`.`parent_id`,
                        `parents_account`.`fName`, 
                        `parents_account`.`lName`, 
                        `parents_account`.`email`
                    FROM
                        `parents_account`
                            INNER JOIN
                        `childs` ON `parents_account`.`parent_id` =`childs`.`parent_id`
                            INNER JOIN
                        `creche` ON `creche`.`creche_id` = `childs`.`creche_id`
                    
                    WHERE
                            `creche`.`creche_id` = :crechId
                    GROUP BY `parents_account`.`parent_id`
                    ORDER BY `parents_account`.`lName`, `parents_account`.`fName`';
        try {
            $resultQueryGetRespLegForCrecheID = $this->bdd->prepare($queryGetRespLegForCrecheID);
            $resultQueryGetRespLegForCrecheID->bindValue(':crechId', $crecheId);

            $result = $resultQueryGetRespLegForCrecheID->execute();;
            if ($result) {
                return $resultQueryGetRespLegForCrecheID->fetchAll();
            } else {
                return false;
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Méthode qui compte le nombre d'enfant lié à un compte parent
     *
     * @param int $respLegId L'id du responsable légal
     * @return int Renvoi le nombre d'enfant associé au responsable Légal
     */
    public function countChildForRespLeg($respLegId)
    {
        $query = 'SELECT COUNT(*) FROM `childs`
             WHERE `childs`.`parent_id` = :respLegId';
        try {
            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->bindValue(':respLegId', $respLegId);
            $result = $resultQuery->execute();

            if ($result) {
                return $resultQuery->fetch();
            } else {
                return false;
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Méthode pour obtenir l'id du responsable légal d'un enfant
     *
     * @param int $childId L'id d'un enfant
     * @return boolean|int L'id du responsable légal si la requete abouti,
     * false dans le cas contraire.
     */
    public function getRespLegIdForChildId($childId)
    {
        $query = 'SELECT
                    `parents_account`.`parent_id`
                  FROM
                    `parents_account`
                  INNER JOIN childs ON
                    `childs`.`parent_id` = `parents_account`.`parent_id`
                  WHERE
                    `childs`.`child_id` = :childId';
        try {
            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->bindvalue(':childId', $childId, PDO::PARAM_INT);
            $result = $resultQuery->execute();
            return $resultQuery->fetch();
        } catch (Exception $exc) {
            die ($exc->getMessage());
        }
    }


    /**
     * Méthode pour supprimer un responsable légal
     *
     * @param int $respLegId L'id du responsable légal.
     * @return boolean vrai si la requete abouti, false dans le cas contraire
     */
    public function deleteRespLeg($respLegId)
    {
        $query = 'DELETE
            FROM `parents_account`
            WHERE `parents_account`.`parent_id` = :respLegId';
        try {
            $resultquery = $this->bdd->prepare($query);
            $resultquery->bindValue(':respLegId', $respLegId, PDO::PARAM_INT);
            return $resultquery->execute();
        } catch (Exception $exc) {
            die($exc->getMessage());
        }
    }
}
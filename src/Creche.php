<?php

namespace CrecheCalendar;

use PDO;
use Exception;

class Creche
{

    private ConnectBdd $DBase;
    private PDO $bdd;

    public function __construct()
    {
        try {
            $this->DBase = new ConnectBdd();
            $this->bdd = $this->DBase->connexion();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Vérifie la validité du numéro SIREN
     *
     * @param $siren
     * @return bool|int
     */
    public function is_siren($siren)
    {
        if (strlen($siren) != 9) {
            return 1;
        } // le SIREN doit contenir 9 caractères
        if (!is_numeric($siren)) {
            return 2;
        } // le SIREN ne doit contenir que des chiffres


        // on prend chaque chiffre un par un
        // si son index (position dans la chaîne en commence à 0 au premier caractère) est impair
        // on double sa valeur et si cette dernière est supérieure à 9, on lui retranche 9
        // on ajoute cette valeur à la somme totale
        $sum = (int)0;
        for ($index = 0; $index < 9; $index++) {
            $number = (int)$siren[$index];
            if (($index % 2) != 0) {
                if (($number *= 2) > 9) {
                    $number -= 9;
                }
            }
            $sum += $number;
        }

        // le numéro est valide si la somme des chiffres est multiple de 10
        if (($sum % 10) === 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Vérifie numéro de siret en concaténant le SIREN et le NIC
     *
     * @param $siren
     * @param $nic
     * @return bool
     */
    public function is_siret($siren, $nic)
    {
        $siret = $siren . $nic;
        if (strlen($siret) != 14)
            return false; // le SIRET doit contenir 14 caractères
        if (!is_numeric($siret))
            return false; // le SIRET ne doit contenir que des chiffres


        // on prend chaque chiffre un par un
        // si son index (position dans la chaîne en commence à 0 au premier caractère) est pair
        // on double sa valeur et si cette dernière est supérieure à 9, on lui retranche 9
        // on ajoute cette valeur à la somme totale
        $sum = (int)0;
        for ($index = 0; $index < 14; $index++) {
            $number = (int)$siret[$index];
            if (($index % 2) === 0) {
                if (($number *= 2) > 9) {
                    $number -= 9;
                }
            }
            $sum += $number;
        }

        // le numéro est valide si la somme des chiffres est multiple de 10
        if (($sum % 10) === 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Vérifie que le mail n'est pas déjà utilisé pour une autre crèche.
     *
     * @param string $mail
     * @return bool
     */
    public function verifyMailExist(string $mail)
    {

        $query = 'SELECT `creche`.`email` FROM `creche` WHERE `creche`.`email` = :crecheEmail';

        try {
            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->bindValue(':crecheEmail', $mail);
            $resultQuery->execute();
            $count = $resultQuery->rowCount();
            if ($count == 0) {
                // Si mail existe dans bdd = false //
                return false;
            } else {
                // Si mail existe pas dans bdd = true //
                return true;
            }

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }


    /**
     * Ajoute une crèche à la bdd
     *
     * @param $managerId
     * @param $crecheName
     * @param $crecheEmail
     * @param $crechePhone
     * @param $crecheAddress1
     * @param $crecheAddress2
     * @param $crecheCodePost
     * @param $crecheCity
     * @param $crecheSiren
     * @param $crecheNic
     */
    public function createCreche($managerId, $crecheName, $crecheEmail, $crechePhone, $crecheAddress1,
                                 $crecheAddress2, $crecheCodePost, $crecheCity, $crecheSiren, $crecheNic)
    {
        $queryCreateCreche = 'INSERT INTO `creche` (
                            `creche`.`crecheName`,
                            `creche`.`email`, 
                            `creche`.`phone`, 
                            `creche`.`address1`, 
                            `creche`.`address2`, 
                            `creche`.`cp`, 
                            `creche`.`city`, 
                            `creche`.`siren`, 
                            `creche`.`nic`)
                          VALUES (
                            :crecheName, 
                            :crecheEmail, 
                            :crechePhone, 
                            :crecheAddress1, 
                            :crecheAddress2, 
                            :crecheCodePost, 
                            :crecheCity, 
                            :crecheSiren,
                            :crecheNic
                          )';

        $queryLinkCrecheManager = 'INSERT INTO `workincreche` (
                                `workincreche`.`creche_id`,
                                `workincreche`.`employees_id`)
                              VALUES (
                                :crecheId,
                                :managerId
                              )';

        try {
            $resultQueryCreateCreche = $this->bdd->prepare($queryCreateCreche);
            $resultQueryCreateCreche->bindValue(':crecheName', $crecheName);
            $resultQueryCreateCreche->bindValue(':crecheEmail', $crecheEmail);
            $resultQueryCreateCreche->bindValue(':crechePhone', $crechePhone);
            $resultQueryCreateCreche->bindValue(':crecheAddress1', $crecheAddress1);
            $resultQueryCreateCreche->bindValue(':crecheAddress2', $crecheAddress2);
            $resultQueryCreateCreche->bindValue(':crecheCodePost', $crecheCodePost);
            $resultQueryCreateCreche->bindValue(':crecheCity', $crecheCity);
            $resultQueryCreateCreche->bindValue(':crecheSiren', $crecheSiren);
            $resultQueryCreateCreche->bindValue(':crecheNic', $crecheNic);
            $resultQueryCreateCreche->execute();

            $lastCrecheId = $this->bdd->lastInsertId();

            $resultQueryLinkCrecheManager = $this->bdd->prepare($queryLinkCrecheManager);
            $resultQueryLinkCrecheManager->bindValue(':crecheId', $lastCrecheId);
            $resultQueryLinkCrecheManager->bindValue(':managerId', $managerId);
            $resultQueryLinkCrecheManager->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }


    /**
     * Récupère la liste de creche associé à l'employé
     *
     * @param $employeeId
     * @return array|false
     */
    public function getCrechesIdByEmployeeId($employeeId)
    {
        $query = 'SELECT 
                `workincreche`.`creche_id`,
                `creche`.`crecheName` 
              FROM 
                `workincreche` 
              INNER JOIN `creche`
              ON `workincreche`.`creche_id` = `creche`.`creche_id`
              INNER JOIN `employees`
              ON `workincreche`.`employees_id` = `employees`.`employees_id`
              WHERE `workincreche`.`employees_id` = :employeeId';

        try {

            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->setFetchMode(PDO::FETCH_ASSOC);
            $resultQuery->bindValue(':employeeId', $employeeId);
            $resultQuery->execute();

            $resultCrechesId = $resultQuery->fetchAll();

            if ($resultQuery) {
                return $resultCrechesId;
            } else {

                return false;
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getCrechesIdByRespLegId($respLegId)
    {
        $query = 'SELECT 
                `workincreche`.`creche_id`,
                `creche`.`crecheName` 
              FROM 
                `workincreche` 
              INNER JOIN `creche`
              ON `workincreche`.`creche_id` = `creche`.`creche_id`
              INNER JOIN `employees`
              ON `workincreche`.`employees_id` = `employees`.`employees_id`
              WHERE `workincreche`.`employees_id` = :employeeId';

        try {

            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->setFetchMode(PDO::FETCH_ASSOC);
            $resultQuery->bindValue(':employeeId', $employeeId);
            $resultQuery->execute();

            $resultCrechesId = $resultQuery->fetchAll();

            if ($resultQuery) {
                return $resultCrechesId;
            } else {

                return false;
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }




    /**
     * Récupère le nom de la crèche
     *
     * @param int $crecheId
     * @return string|false
     */
    public function getCrecheNameById(int $crecheId)
    {
        $query = 'SELECT 
                    `creche`.`crecheName`
                FROM `creche`
                WHERE `creche`.`creche_id` = :creche_id';
        try {

            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->setFetchMode(PDO::FETCH_ASSOC);
            $resultQuery->bindValue(':creche_id', $crecheId);
            $resultQuery->execute();

            $result = $resultQuery->fetch()['crecheName'];

            if ($resultQuery) {
                return $result;
            } else {
                return false;
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }


    /**
     * Supprime une creche à partir de son id
     *
     * @param int $crecheId
     * @return void|false
     */
    public function deleteCreche(int $crecheId){
        $query = 'DELETE 
                    FROM `creche`
                    WHERE `creche`.`creche_id` = :creche_id';
        try {

            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->setFetchMode(PDO::FETCH_ASSOC);
            $resultQuery->bindValue(':creche_id', $crecheId);
            $resultQuery->execute();

            $result = $resultQuery->rowCount();



            return $result;

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}

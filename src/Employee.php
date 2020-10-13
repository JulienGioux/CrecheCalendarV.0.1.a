<?php
/**
 * Projet CrechCalendar Class Employee
 *
 */

namespace CrecheCalendar;

/**
 * Cette classe définie un employé.
 */
class Employee extends User {

    
    public function createCrecheManager($fName, $lName, $gender, $userEmail, $userPhone, $password, $function) {
        $query = 'INSERT INTO `employees` (`fName`, `lName`, `gender_id`, `email`, `userPhone`, `password`, `role_id`, `function_id`) 
        VALUES (:manager_fName, :manager_lName, :manager_genderId, :manager_email, :manager_userPhone, :manager_password, :manager_roleId, :manager_functionId)';
        try {
            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->bindValue(':manager_fName', $fName);
            $resultQuery->bindValue(':manager_lName', $lName);
            $resultQuery->bindValue(':manager_genderId', $gender);
            $resultQuery->bindValue(':manager_email', $userEmail);
            $resultQuery->bindValue(':manager_userPhone', $userPhone);
            $resultQuery->bindValue(':manager_password', $password);
            $resultQuery->bindValue(':manager_roleId', '2');
            $resultQuery->bindValue(':manager_functionId', $function);
            $resultQuery->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }    
    }
    
    public function createEmployee($fName, $lName, $gender, $userEmail, $userPhone, $password, $function, $role, $crecheId=null, $sectionId=null) {
        $query = 'INSERT INTO `employees` (`fName`, `lName`, `gender_id`, `email`, `userPhone`, `password`, `function_id`, `role_id`, `section_id`) 
        VALUES (:employee_fName, :employee_lName, :employee_genderId, :employee_email, :employee_userPhone, :employee_password, :employee_functionId, :employee_roleId, :employee_sectionId)';
        $queryWorkInCreche = 'INSERT INTO `workincreche` (`creche_id`, `employees_id`)
        VALUES (:employee_crecheId, :employee_id)';
        try {
            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->bindValue(':employee_fName', $fName);
            $resultQuery->bindValue(':employee_lName', $lName);
            $resultQuery->bindValue(':employee_genderId', $gender);
            $resultQuery->bindValue(':employee_email', $userEmail);
            $resultQuery->bindValue(':employee_userPhone', $userPhone);
            $resultQuery->bindValue(':employee_password', $password);
            $resultQuery->bindValue(':employee_functionId', $function);
            $resultQuery->bindValue(':employee_roleId', $role);
            $resultQuery->bindValue(':employee_sectionId', $sectionId);
            $resultQuery->execute();
            if ($crecheId != null) {
                $lastEmployeeId = $this->bdd->lastInsertId();
                $resultQueryWorkInCreche = $this->bdd->prepare($queryWorkInCreche);
                $resultQueryWorkInCreche->bindValue(':employee_id', $lastEmployeeId);
                $resultQueryWorkInCreche->bindValue(':employee_crecheId', $crecheId);
                $resultQueryWorkInCreche->execute();
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }    
    }

    public function getEmployeeInfo($userEmail) {
        $query = '
        SELECT
            `employees`.`employees_id` AS userId,
            `employees`.`fName`,
            `employees`.`lName`,
            `employees`.`password`,
            `employees`.`photo_profil_name`,
            `employees`.`email` AS userEmail,
            `employees`.`userphone`,
            `roles`.`role_name` AS role,
            `functions`.`function_name`,
            `genders`.`gender`,
            `sections`.`section_name`
        FROM
            `employees`
        LEFT JOIN `roles` ON
            `employees`.`role_id` = `roles`.`role_id`
        LEFT JOIN `functions` ON
            `employees`.`function_id` = `functions`.`function_id`
        LEFT JOIN `genders` ON
            `employees`.`gender_id` = `genders`.`gender_id`
        LEFT JOIN `sections` ON
            `employees`.`section_id` = `sections`.`section_id`
        WHERE
            `employees`.`email` = :userEmail';
        try {
            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->bindValue(':userEmail', $userEmail);
            $resultQuery->execute();
            $resultUser = $resultQuery->fetchObject(Employee::class);

            return $resultUser ?? null;

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }    
    }
}
<?php


namespace CrecheCalendar;


use Exception;

class User
{
    public $userId;
    public $userEmail;
    public $password;
    public $role;

    /**
     * Constructeur défini la connection à la base de donnée
     *
     * @return void
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
     * Vérifie si un email est déjà présent
     *
     * @param string $mail Un email valide
     *
     * @return boolean Renvoi true si le mail n'existe pas et false si il existe dans la base de donnée
     */
    public function verifyMailExist(string $mail, string $role) {
        if (($this->role === 'Employé' || $this->role === 'Modérateur')
            || $role === 'Modérateur' || $role === 'Employé') {
            $query = 'SELECT `email` FROM `employees` WHERE `email` = :userMail';
        } else {
            $query = 'SELECT `email` FROM `parents_account` WHERE `email` = :userMail';
        }

        try {
            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->bindValue(':userMail', $mail);
            $resultQuery->execute();
            $count = $resultQuery->rowCount();
            if ($count == 0) {
                // Si mail existe dans bdd = false //
                return false;
            } else {
                // Si mail n'existe pas dans bdd = true //
                return true;
            }

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function VerifyLogin(string $mail, string $password, bool $isEmployee)
    {
        if ($isEmployee) {
            $query = 'SELECT `employees`.`email`, `employees`.`password` FROM `employees` WHERE `employees`.`email` = :userEmail ';
        } else {
            $query = 'SELECT `parents_account`.`email`, `parents_account`.`password` FROM `parents_account` WHERE `parents_account`.`email` = :userEmail';
        }

        try {
            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->bindValue(':userEmail', $mail);
            $resultQuery->execute();
            $resultUser = $resultQuery->fetch();
            if ($resultUser) {
                return password_verify($password, $resultUser['password']);
            } else {
                return false;
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
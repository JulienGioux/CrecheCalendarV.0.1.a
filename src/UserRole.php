<?php
namespace CrecheCalendar;

class UserRole {
    
    public function __construct() {
        try {
            $this->DBase = new ConnectBdd();
            $this->bdd = $this->DBase->connexion();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
    
    public function getAllRoles()
    {
        $query = 'SELECT `role_id`, `role_name`, `role_description` FROM `roles`';
        try {
            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->execute();
            $result = $resultQuery->fetchAll();
            if ($resultQuery) {
                return $result;
            } else {
                return false;
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function getRoleName ($roleId) {
        $query = 'SELECT `role_name` FROM `roles` WHERE `role_id` = :roleId';
        try {
            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->bindValue(':roleId', $roleId);
            $resultQuery->execute();
            $result = $resultQuery->fetch();
            if ($resultQuery) {
                return $result;
            } else {
                return false;
            }
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
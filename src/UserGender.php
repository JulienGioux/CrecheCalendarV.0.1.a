<?php
namespace CrecheCalendar {


    class UserGender {

        /**
         * UserGender constructor.
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
         * récupère la liste des genres
         *
         * @return array|false
         */
        public function getGenders() {
            $query = 'SELECT `gender_id`, `gender` FROM `genders`';
            try {
                $resultQuery = $this->bdd->prepare($query);
                $resultQuery->execute();
                $resultAllGenders = $resultQuery->fetchAll();
                if ($resultAllGenders) {
                    return $resultAllGenders;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
    }
}

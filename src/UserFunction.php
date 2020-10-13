<?php
namespace CrecheCalendar {

    class UserFunction {

        public function __construct() {
            try {
                $this->DBase = new ConnectBdd();
                $this->bdd = $this->DBase->connexion();
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }

        public function getFunctions()
        {
            $query = 'SELECT `function_id`, `function_name`, `function_description` FROM `functions`';
            try {
                $resultQuery = $this->bdd->prepare($query);
                $resultQuery->execute();
                $resultFunction = $resultQuery->fetchAll();
                if ($resultFunction) {
                    return $resultFunction;
                } else {
                    return false;
                }
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
        }
    }

}

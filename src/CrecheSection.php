<?php
namespace CrecheCalendar;
use PDO;
use Exception;
class CrecheSection {
  private $DBase;
  private $bdd;

    /**
     * CrecheSection constructor.
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
     * @param $crecheId
     * @return array|false
     */
    public function getAllSectionsByCrecheId($crecheId) {
    $query =
      'SELECT 
        `sections`.`section_Name`,
        `sections`.`section_id`
      FROM 
      `sections`
      WHERE `sections`.`creche_id` = :crecheId';
    
    try {

      $resultQuery = $this->bdd->prepare($query);
      $resultQuery->bindValue(':crecheId', $crecheId);
      $resultQuery->execute();

      $resultAllSections = $resultQuery->fetchAll();

      if ($resultAllSections) {
          return $resultAllSections;
      } else {

          return false;
      }
      
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
  }

    /**
     * @param $sectionId
     * @return false|mixed
     */
    public function getSectionById($sectionId){
      $query =
          'SELECT 
        `sections`.`section_Name`,
        `sections`.`section_id`
      FROM 
      `sections`
      WHERE `sections`.`section_id` = :sectionId';

      try {

          $resultQuery = $this->bdd->prepare($query);
          $resultQuery->bindValue(':sectionId', $sectionId);
          $resultQuery->execute();

          $resultSection = $resultQuery->fetch();

          if ($resultQuery) {
              return $resultSection;
          } else {
              return false;
          }

      } catch (Exception $e) {
          die('Erreur : ' . $e->getMessage());
      }
  }

    /**
     * @param $section_Name
     * @param $crecheId
     * @param string $section_description
     * @param string $section_logo_name
     */
    public function createSection($section_Name, $crecheId, $section_description='Description de la section...', $section_logo_name='defaultSection.png') {
    $queryCreateSection = 
      'INSERT INTO `sections` (
        `sections`.`section_Name`,
        `sections`.`section_description`,
        `sections`.`section_logo_name`,
        `sections`.`creche_id`)
      VALUES (
        :section_Name,
        :section_description,
        :section_logo_name,
        :creche_id
      )';
  
    try {

      $resultQueryCreateSection = $this->bdd->prepare($queryCreateSection);
      $resultQueryCreateSection->bindValue(':section_Name', $section_Name);
      $resultQueryCreateSection->bindValue(':section_description', $section_description);
      $resultQueryCreateSection->bindValue(':section_logo_name', $section_logo_name);
      $resultQueryCreateSection->bindValue(':creche_id', $crecheId);

      $resultQueryCreateSection->execute();
      
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
  }


    /**
     * Supprime une section à partir de son id
     *
     * @param int $sectionId
     * @return void|false
     */
    public function deleteSection(int $sectionId){
        $query = 'DELETE 
                        FROM `sections`
                        WHERE `sections`.`section_id` = :section_id';
        try {

            $resultQuery = $this->bdd->prepare($query);
            $resultQuery->setFetchMode(PDO::FETCH_ASSOC);
            $resultQuery->bindValue(':section_id', $sectionId);
            $resultQuery->execute();

            $result = $resultQuery->rowCount();



            return $result;

        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
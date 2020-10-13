<?php

namespace CrecheCalendar\Calendar;

use CrecheCalendar\ConnectBdd;
use DateTime;
use Exception;
use PDO;

/**
 * Premet de gérer les événements
 */
class Events
{

    private ConnectBdd $DBase;
    private PDO $bdd;

    /**
     * Constructeur défini la connection à la base de donnée
     *
     *
     */
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
     * Permet de récupérer tous les évènements commençant entre 2 dates.
     *
     * @param DateTime|null $start Date de début
     * @param DateTime|null $end Date de fin
     * @return array|false
     */
    public function getEventsBetween(DateTime $start = null, DateTime $end = null)
    {
        $query = '
        SELECT
          calendarSlots_id,
          slots_start,
          slots_end,
          notes,
          childs.fName,
          childs.child_id,
          childs.lName,
          slot_types.slot_types_id,
          slot_types.slot_types,
          sections.section_id,
          sections.section_Name
        FROM
          calendar_slots_childs
        LEFT JOIN slot_types ON
          slot_types.slot_types_id = calendar_slots_childs.slot_types_id
        LEFT JOIN sections ON
          sections.section_id = calendar_slots_childs.section_id
        LEFT JOIN childs ON
          childs.child_id = calendar_slots_childs.child_id
        WHERE
          calendar_slots_childs.slots_start
          AND calendar_slots_childs.slots_end BETWEEN :startDate AND :endDate';

        try {
            $statement = $this->bdd->prepare($query);
            $statement->bindValue(':startDate', $start->format('Y-m-d H:i:s'));
            $statement->bindValue(':endDate', $end->format('Y-m-d H:i:s'));


            $result = $statement->execute();

            if ($result) {
                return $statement->fetchAll();
            } else {
                return false;
            }
        } catch (Exception $exc) {
            die($exc->getMessage());
        }
    }


    /**
     * Permet de récupérer tous les évènements commençant entre 2 dates.
     *
     * @param DateTime|null $start Date de début
     * @param DateTime|null $end Date de fin
     * @return array
     */
    public function getEventsBetweenByDay(DateTime $start = null, DateTime $end = null): array
    {
        $events = $this->getEventsBetween($start->modify('00:00:00'), $end->modify('23:59:59'));
        $days = [];

        foreach ($events as $event) {
            $date = explode(' ', $event['slots_start'])[0];
            if (!isset($days[$date])) {
                $days[$date] = [$event];
            } else {
                $days[$date][] = $event;
            }
        }

        return $days;
    }
}
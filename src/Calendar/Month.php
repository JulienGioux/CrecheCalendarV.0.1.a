<?php


namespace CrecheCalendar\Calendar;

use Datetime;
use Exception;

class Month
{
    public array $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'samedi', 'dimanche'];
    private array $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    public $month;
    public $year;

    /**
     * Month constructor.
     *
     * @param int|null $month le mois compris entre 1 et 12
     * @param int|null $year L'année.
     * @throws Exception
     */
    public function __construct(int $month = null, int $year = null)
    {
        if ($month === null || $month > 12 || $month < 1) {
            $month = intval(date('m'));
        }
        if ($year === null) {
            $year = intval(date('Y'));
        }
        if ($month < 1 || $month > 12) {
            throw new Exception('Le mois ' . $month . ' n\'est pas valide');
        }
        if ($year < 1970) {
            throw new Exception('L\'année ' . $year . ' n\'est pas valide');
        }
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * Renvoie le 1er jour du mois
     *
     * return string
     * @throws Exception
     */
    public function getStartingDay(): Datetime
    {
        return new DateTime($this->year . '-' . $this->month . '-01');
    }

    /**
     * Retourne le mois en toute lettre (ex : Mars 2018)
     *
     * @return string
     */
    public function toString(): string
    {
        return $this->months[$this->month - 1] . ' ' . $this->year;
    }

    /**
     * Renvoie le nombre de semaine à afficher
     *
     * @return int
     * @throws Exception
     */
    public function getWeeks(): int
    {
        $firstDayOfMonth = $this->getStartingDay();
        $start = (clone $firstDayOfMonth)->modify('monday this week');
        $lastDayOfMonth = (clone $firstDayOfMonth)->modify('last day of this month');
        $end = (clone $lastDayOfMonth)->modify('sunday this week');
        $interval = $start->diff($end);
        $weeks = round(intval($interval->format('%a')) / 7, 0);
        return intval($weeks);
    }

    /**
     * Permet de savoir si le jour passé en paramètre est dans le mois en cours
     *
     * @param DateTime $date
     * @return bool
     * @throws Exception
     */
    public function withinMonth(DateTime $date): bool
    {
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * renvoie le mois suivant
     *
     * @return Month
     * @throws Exception
     */
    public function nextMonth(): Month
    {
        $month = $this->month + 1;
        $year = $this->year;
        if ($month > 12) {
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    /**
     * Renvoie le mois précédant
     *
     * @return Month
     * @throws Exception
     */
    public function previousMonth(): Month
    {
        $month = $this->month - 1;
        $year = $this->year;
        if ($month < 1) {
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }
}
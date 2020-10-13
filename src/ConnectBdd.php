<?php
namespace CrecheCalendar;

use PDO;
use PDOException;

class ConnectBdd
{
    private $bdd;
    // Paramètre serveur perso :
    private string $connec_host = 'localhost';
    private string $connec_dbname = 'crechecalendar';
    private string $connec_pseudo = 'CCROOT';
    private string $connec_mdp = 'g=xXiG#V';

//    private $connec_host = 'localhost';
//    private $connec_dbname = 'projpro';
//    private $connec_pseudo = 'root';
//    private $connec_mdp = 'g=xXiG#V';

    public function __construct(){

        try {
            $this->bdd = new PDO('mysql:host='.$this->connec_host.';dbname='.$this->connec_dbname, $this->connec_pseudo, $this->connec_mdp);

            $this->bdd->exec("SET CHARACTER SET utf8");
            $this->bdd->exec("SET NAMES utf8");
            // Activation des erreurs PDO
            $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // mode fetch par défaut : FETCH_ASSOC / FETCH_OBJ / FETCH_BOTH
            $this->bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        }
        catch(PDOException $e) {
            die('<h3>Erreur !</h3>' . $e->getMessage());
        }
    }

    public function connexion(){
        return $this->bdd;
    }
}

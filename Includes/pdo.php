<?php
class PdoProjetWeb
{

    private static $serveur = 'mysql:host=localhost';
    private static $bdd = 'dbname=projetweb';
    private static $user = 'projetweb';
    private static $mdp = 'projetweb';
    private static $monPdo;
    private static $monPdoProjetWeb = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct()
    {
        PdoProjetWeb::$monPdo = new PDO(
            PdoProjetWeb::$serveur . ';' . PdoProjetWeb::$bdd,
            PdoProjetWeb::$user,
            PdoProjetWeb::$mdp
        );
        PdoProjetWeb::$monPdo->query('SET CHARACTER SET utf8');
    }

    /**
     * Méthode destructeur appelée dès qu'il n'y a plus de référence sur un
     * objet donné, ou dans n'importe quel ordre pendant la séquence d'arrêt.
     */
    public function __destruct()
    {
        PdoProjetWeb::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
     *
     * @return l'unique objet de la classe PdoGsb
     */
    public static function getPdoProjetWeb() {
        if (PdoProjetWeb::$monPdoProjetWeb == null) {
            PdoProjetWeb::$monPdoProjetWeb = new PdoProjetWeb();
        }
        return PdoProjetWeb::$monPdo;
    }
}
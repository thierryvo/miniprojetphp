<?php
// création d'une Class pour se connecter
class connect extends PDO{
    const HOST="localhost";
    const DB="gestioncommandes";  // gestioncommandes / test2
    const USER="root";
    const PASS="";
    private $dbport=3307;

    // CONSTRUCTEUR
    public function __construct(){
        $GLOBALS['information_message'] = "";
        // Options de connexion
        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactiver le mode d'émulation pour les "vraies" instructions préparées
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Désactiver les erreurs sous forme d'exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Faire en sorte que la récupération par défaut soit un tableau associatif
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',       // utf8 
        ];
        $_SETTINGS = parse_ini_file('./_settings.ini', true);
        // CONNEXION PDO ----------------------------------------------------------------------------------------
        try{
            $le_cas = "01";
            switch($le_cas){
                case "01":
                    // en dure
                    // chaine de connexion
                    parent::__construct("mysql:host=" .self::HOST. ";port=" .$this->dbport. ";dbname=" .self::DB.'',
                            self::USER,
                            self::PASS,
                            $options
                    );
                    $msg = "la connexion est ouverte, 01: en dure";
                    $GLOBALS['connexion_message'] = $msg;
                    break;
                case "02":
                    // avec les paramètres settings
                    // chaine de connexion
                    parent::__construct("mysql:host={$_SETTINGS['db']['host']};port={$_SETTINGS['db']['port']};dbname={$_SETTINGS['db']['name']}",
                       $_SETTINGS['db']['user'],
                       $_SETTINGS['db']['pass'],
                       $options
                    );
                    $msg = "la connexion est ouverte, 02: avec le fichier _settings.ini";
                    $GLOBALS['connexion_message'] = $msg;
                    break;
            }
        }
        catch(PDOException $e){
            $msg = "ECHEC de la connexion BDD" .$e->getMessage(). "" .$e->getFile(). "" .$e->getLine().'.';
            $GLOBALS['connexion_message'] = $msg;
        }
    }
}

<?php
/**
 * General PageHandler
 * Stellt gemeinsame Konstanten und Funktionen zur Verfügung
 *
 * @author mwegmann
 */
require_once('../system/db/database.class.php');

class pageHandler {
    // tables
    const DB_TABLE_USERS = "itc-grades-tool_users";
    const DB_TABLE_GRADES = "itc-grades-tool_grades";
    const DB_TABLE_COURSES = "itc-grades-tool_courses";
    const DB_TABLE_PROJECTS = "itc-grades-tool_projects";
    const DB_TABLE_PROJECT_PARTY = "itc-grades-tool_project_participants";

    // text
    const ERR_EMPTY_INPUT = "Bitte alle erforderlichen Felder ausfüllen.";
    const ERR_USERNAME_EXISTS = "Dieser Nutzername existiert bereits.";
    const ERR_EMAIL_EXISTS = "Es gibt bereits einen Nutzer mit dieser Email-Adresse.";
    const ERR_EMAIL_INVALID = "Keine akzeptierte Email-Adresse.";
    const SUCCESS_REG = "Nutzer erfolgreich angelegt.";
    const ERR_INVALID_LOGIN = "Kein gültiges Login.";
    const ERR_INVALID_PASS = "Kein gültiges Passwort.";
    const ERR_QUERY_RETURNS_FALSE = "Da ist wohl ein Fehler mit der Datenbank passiert.";
    const ERR_INPUT_TOO_SHORT = "Nutzername und Passwort müssen je mindestens 4 Zeichen lang sein.";
    const ERR_USERNAME_TOO_SHORT = "Ihr Nutzername sollte mindestens 4 Zeichen lang sein.";
    const ERR_PW_TOO_SHORT = "Ihr Passwort muss mindestens 4 Zeichen lang sein.";
    const ERR_PW_NOT_EQUAL = "Die eingegebenen Passwörter stimmen nicht überein.";
    const ERR_WRONG_OLD_PW = "Das eingegebene Passwort ist nicht richtig.";

    protected $db;
    private $result;

    function __construct() {
        $config = new dbconfig();
        $this->db = new database($config);
        $this->db->openConnection();
    }

    public function checkIfLogin() {
        if(isset($_COOKIE['username']) && isset($_COOKIE['pass'])) {

            $query = $this->db->selectRows(self::DB_TABLE_USERS, "*", "username", $_COOKIE['username']);

            // Ungültiger Username Cookie
            if(!$this->db->hasRows($query)) {
                return false;
            }

            // ungültiger Password Cookie
            $result = $this->db->fetchAssoc($query);
            if($_COOKIE['pass'] != $result[0]['pass']) {
                return false;
            }
            // wenn Username und Passwort gültig: $result verfügbar machen
            $this->result = $result[0];
            return true;
        }
        return false;
    }

    public function getUsername() {
        if(isset($this->result)) {
            return $this->result['username'];
        }
        return false;
    }

    public function getVorname() {
        if(isset($this->result)) {
            return $this->result['vorname'];
        }
        return false;
    }

    public function getNachname() {
        if(isset($this->result)) {
            return $this->result['nachname'];
        }
        return false;
    }

    public function getEmail() {
        if(isset($this->result)) {
            return $this->result['email'];
        }
        return false;
    }

    public function getID() {
        if(isset($this->result)) {
            return $this->result['ID'];
        }
        return false;
    }

    public function getPW() {
        if(isset($this->result)) {
            return $this->result['pass'];
        }
        return false;
    }

    // Zum einfacheren Testen zwischendurch
    public function print_r_test($test) {
        echo "<pre>";
        print_r($test);
        echo "</pre>";
    }

    // Immer wenn wir UserInput als html ausgeben
    protected function sanitizeOutput($string) {
        return htmlspecialchars($string);
    }

    // Ist eines der Elemente leer?
    protected function checkIfEmpty($input) {
        foreach($input as $item) {
            if($item == "") return false;
        }
        return true; // nur wahr wenn kein Item leer
    }

    // Jedes Element auf bestimmte Länge prüfen
    protected function checkIfLength($input) {
        foreach($input as $item => $length) {
            if(strlen( $item) < $length ) return false;
        }
        return true;
    }
    
    //Generiert die UsrID aus dem Username
    public function getUserID($pUser){
        $query = $this->db->selectRows(self::DB_TABLE_USERS, 'ID', 'username', $pUser);
        $result = $this->db->fetchAssoc($query);
        return $result[0]['ID'];
    }
}

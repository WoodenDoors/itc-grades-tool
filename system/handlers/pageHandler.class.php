<?php
/**
 * General PageHandler
 * Stellt gemeinsame Konstanten und Funktionen zur Verfügung
 *
 * @author mwegmann
 */
require_once(__DIR__.'/../db/database.class.php');

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

    const ERR_GRADES_WRONG_SYNTAX = "Falsche Syntax der Note.";
    const ERR_GRADES_WRONG_RANGE = "Die Eingegebene Note liegt nicht zwischen 1.0 und 5.0";
    const ERR_GRADE_ALREADY_EXISTS = "Für dieses Fach ist bereits eine Note eingetragen.";
    const ERR_GRADES_NIL = "Die eingegebene Note ist ungültig.";

    protected $db;
    private $user;

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
            $this->user = $result[0];
            return true;
        }
        return false;
    }

    public function getUsername() {
        if(isset($this->user)) {
            return $this->user['username'];
        }
        return false;
    }

    public function getVorname() {
        if(isset($this->user)) {
            return $this->user['vorname'];
        }
        return false;
    }

    public function getNachname() {
        if(isset($this->user)) {
            return $this->user['nachname'];
        }
        return false;
    }

    public function getEmail() {
        if(isset($this->user)) {
            return $this->user['email'];
        }
        return false;
    }

    public function getID() {
        if(isset($this->user)) {
            return $this->user['ID'];
        }
        return false;
    }

    public function getPW() {
        if(isset($this->user)) {
            return $this->user['pass'];
        }
        return false;
    }

    public function getSemester() {
        if(isset($this->user)) {
            if($this->user['semester'] > 0 && $this->user['semester'] < 6)
                $semester = $this->user['semester'];
            else
                $semester = 1;
            return $semester;
        }
        return false;
    }

    // Zum einfacheren Testen zwischendurch
    public function print_r_test($test) {
        echo "<pre>";
        print_r($test);
        echo "</pre>";
    }

    // Ausgelagert aus addGrades, da öfter nötig
    public function getCourses($semester=NULL){
        if($semester==NULL) $semester = $this->getSemester();

        $query = $this->db->selectRows(self::DB_TABLE_COURSES, 'abbreviation, course', 'semester', $semester);
        return $this->db->fetchAssoc($query);
    }

    // Nimmt sowohl Kürzel als auch ID als Parameter
    public function getCourseName($abbreviationOrID){
        if(is_numeric($abbreviationOrID)) {
            $searchField = 'ID';
        } else {
            $searchField = 'abbreviation';
        }
        $query = $this->db->selectRows(self::DB_TABLE_COURSES, 'course', $searchField, $abbreviationOrID);
        return $this->db->fetchAssoc($query)[0]['course'];
    }

    protected function getCourseID($pCourse){
        $query = $this->db->selectRows(self::DB_TABLE_COURSES, 'ID', 'abbreviation', $pCourse);
        return $this->db->fetchAssoc($query)[0]['ID'];
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

    //Prüfung, ob die Note syntaktisch richtig ist
    protected function checkGradeFormat(&$pGrade, $allowNullNull=false){

        //Bei korrekter EIngabe mit Komma wird das durch einen Punkt ersetzt
        if (preg_match('/^[0-9]{1}[,]{1}[0-9]{1}$/', $pGrade)){
            $pGrade[1]='.';
        }

        if (!preg_match('/^[0-9]{1}[.]{1}[0-9]{1}$/', $pGrade)){
            return self::ERR_GRADES_WRONG_SYNTAX;
        }

        // Vorzeitig true wenn 0.0 (und 0.0 erlaubt)
        if($allowNullNull===true && $pGrade == 0.0) {
            return true;
        }

        // Note zwischen 1.0 und 5.0 - Prüfung erfolgt nur wenn 0.0 nicht erlaubt ist
        if( ( $pGrade<1.0 ) || ( $pGrade>5.0 ) ){
            return self::ERR_GRADES_WRONG_RANGE;
        }

        // Note darf nur bestimmte Werte
        $validGrades = [ 1.0, 1.3, 1.7, 2, 2.3, 2.7, 3.0, 3.3, 3.7, 4.0, 5.0 ];
        // Quellen: https://www-sec.uni-regensburg.de/pnz/index.html.de || http://www.uni-passau.de/4937.html || http://de.wikipedia.org/wiki/Schulnote#Hochschule
        if ( !in_array($pGrade, $validGrades) ){
            return self::ERR_GRADES_NIL;
        }
        return true;
    }

}

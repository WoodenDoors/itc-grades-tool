<?php
/**
 * Handler register.php
 *
 * @author mwegmann
 */
require_once('../system/db/database.class.php');

class registerHandler {
    const DB_TABLE = "`itc-grades-tool_users`";
    
    // Braucht anständiges Error-Handling
    const ERR_EMPTY_INPUT = "Bitte alle Felder ausfüllen.";
    const ERR_USERNAME_EXISTS = "Dieser Nutzername existiert bereits.";
    const ERR_EMAIL_EXISTS = "Es gibt bereits einen Nutzer mit dieser Email-Adresse.";
    const ERR_EMAIL_INVALID = "Keine akteptierte Email-Adresse.";
    const SUCCESS = "Nutzer erfolgreich angelegt.";
    
    private $db;
    private $username;
    private $vorname;
    private $nachname;
    private $email;
    private $pass;
    
    function __construct($username, $vorname, $nachname, $email, $pass) {
        $this->username = $username;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->email = $email;
        $this->pass = $pass;
        
        $config = new dbconfig();
        $this->db = new database($config);
        $this->db->openConnection();
    }
    
    function __destruct() {
        $this->db->closeConnection();
    }
    
    public function validateInput() {
        // Alle auf leer prüfen
        if(!$this->checkIfEmpty( array($this->username, $this->vorname, $this->nachname, $this->email, $this->pass) )) {
            return registerHandler::ERR_EMPTY_INPUT;
        }
        
        // Existiert Nutzername bereits?
        $string=
                "SELECT `username` FROM " .registerHandler::DB_TABLE.
                " WHERE `username` = '" .$this->sanitizeInput($this->username). "'";  SELECT *
        $userExists = $this->db->query($string);
        if($this->db->hasRows($userExists)) {
             return registerHandler::ERR_USERNAME_EXISTS." ".$string;
        }
        
         // Existiert Email bereits?
        $mailExists = $this->db->query(
                "SELECT `email` FROM " .registerHandler::DB_TABLE. 
                " WHERE `email` = '" .$this->sanitizeInput($this->email). "'");
        if($this->db->hasRows($mailExists)) {
             return registerHandler::ERR_EMAIL_EXISTS;
        }
        
        // Gültige Email-Adresse prüfen
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return registerHandler::ERR_EMAIL_INVALID;
        }
        
        // Sonst kein Fehler
        return false;
    }
    
    public function submitInput() {
        
    }
    
    private function sanitizeInput($string) {
        return $this->db->ecapeString($string);
    }
    
    private function sanitizeOutput($string) {
        return htmlspecialchars($string);
    }
    
    private function checkIfEmpty($input) {
        foreach($input as $item) {
            if($item == "") return false;
        }
        return true; // nur wahr wenn kein Item leer
    }
}
?>

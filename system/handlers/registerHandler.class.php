<?php
/**
 * Handler for register.php
 *
 * @author mwegmann
 */
require_once('../system/db/database.class.php');
require_once('../system/general/Constants.class.php');

class registerHandler {
    const DB_TABLE = "`itc-grades-tool_users`";

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
            return Constants::ERR_EMPTY_INPUT;
        }
        
        // Existiert Nutzername bereits?
        $string=
                "SELECT `username` FROM " .registerHandler::DB_TABLE.
                " WHERE `username` = '" .$this->sanitizeInput($this->username). "'";  SELECT *
        $userExists = $this->db->query($string);
        if($this->db->hasRows($userExists)) {
             return Constants::ERR_USERNAME_EXISTS." ".$string;
        }
        
         // Existiert Email bereits?
        $mailExists = $this->db->query(
                "SELECT `email` FROM " .registerHandler::DB_TABLE. 
                " WHERE `email` = '" .$this->sanitizeInput($this->email). "'");
        if($this->db->hasRows($mailExists)) {
             return Constants::ERR_EMAIL_EXISTS;
        }
        
        // Gültige Email-Adresse prüfen
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return Constants::ERR_EMAIL_INVALID;
        }
        
        // Wenn alles ok, an Submit-Funktion übergeben
        return $this->submitInput();
    }
    
    private function submitInput() {
        return false;
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

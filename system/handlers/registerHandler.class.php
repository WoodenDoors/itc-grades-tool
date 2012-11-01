<?php
/**
 * Handler for register.php
 *
 * @author mwegmann
 */
require_once('pageHandler.class.php');
require_once('../system/db/database.class.php');

class registerHandler extends pageHandler {

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
    
    function __destruct() { }
    
    public function validateInput() {
        // Alle auf leer prüfen
        if(!$this->checkIfEmpty( array($this->username, $this->vorname, $this->nachname, $this->email, $this->pass) )) {
            return parent::ERR_EMPTY_INPUT;
        }
        
        // Existiert Nutzername bereits?
        $userExists = $this->db->selectRows("*", parent::DB_TABLE_USERS, "username", $this->username);
        if($this->db->hasRows($userExists)) {
             return parent::ERR_USERNAME_EXISTS;
        }
        
         // Existiert Email bereits?
        $mailExists = $this->db->selectRows("*", parent::DB_TABLE_USERS, "email", $this->email);
        if($this->db->hasRows($mailExists)) {
             return parent::ERR_EMAIL_EXISTS;
        }
        
        // Gültige Email-Adresse prüfen
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return parent::ERR_EMAIL_INVALID;
        }
        
        // Wenn alles ok, an Submit-Funktion übergeben
        return $this->submitInput();
    }
    
    private function submitInput() {
        return false;
    }
}
?>

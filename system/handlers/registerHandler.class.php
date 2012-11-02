<?php
/**
 * Handler for register.php
 *
 * @author mwegmann
 */
require_once('pageHandler.class.php');

class registerHandler extends pageHandler {
    
    function __construct() {
        parent::__construct();
    }
    
    function __destruct() { }
    
    public function validateInput($username, $vorname, $nachname, $email, $pass) {
        $dataArray =  array( $username, $vorname, $nachname, $email, $pass );

        // Alle auf leer prüfen
        if(!$this->checkIfEmpty( $dataArray )) {
            return parent::ERR_EMPTY_INPUT;
        }

        // Alles mindestens 2 Zeichen lang
        // TODO: ist das Sinnvoll?
        if(!$this->checkIfLength( $dataArray, 2 )) {
            return parent::ERR_INPUT_UNDERSIZED;
        }
        
        // Existiert Nutzername bereits?
        $userExists = $this->db->selectRows( parent::DB_TABLE_USERS, "*", "username", $username );
        if($this->db->hasRows($userExists)) {
             return parent::ERR_USERNAME_EXISTS;
        }
        
         // Existiert Email bereits?
        $mailExists = $this->db->selectRows( parent::DB_TABLE_USERS, "*", "email", $email );
        if($this->db->hasRows($mailExists)) {
             return parent::ERR_EMAIL_EXISTS;
        }
        
        // Gültige Email-Adresse prüfen
        if(!filter_var( $email, FILTER_VALIDATE_EMAIL )) {
            return parent::ERR_EMAIL_INVALID;
        }
        
        // Wenn alles ok, an Submit-Funktion übergeben
        return $this->submitInput( $dataArray );
    }
    
    private function submitInput($dataArray) {
        $dataArray[4] = md5($dataArray[4]); // Passwort in md5() wandeln

        $this->db->insertRow(
            parent::DB_TABLE_USERS,
            $dataArray,
            "username, vorname, nachname, email, pass"
        );
        return false;
    }
}
?>

<?php
/**
 * Handler for settings.php
 *
 * @author: MWegmann
 */
require_once('pageHandler.class.php');

class settingsHandler extends pageHandler {

    function __construct() {
        parent::__construct();
    }

    function __destruct() { }

    public function validateNameSettings($username, $vorname, $nachname, $email, $semester) {

        // Benötigte Felder auf leer prüfen
        if(!$this->checkIfEmpty( [$username, $email] )) {
            return parent::ERR_EMPTY_INPUT;
        }

        // Username mindestens 4 lang
        if(!$this->checkIfLength( [$username => 4] )) {
            return parent::ERR_USERNAME_TOO_SHORT;
        }

        // Existiert Nutzername bereits? (momentaner Nutzername ausgeschlossen)
        if( $username != $this->getUsername()) {
            $userExists = $this->db->selectRows( parent::DB_TABLE_USERS, "*", "username", $username );
            if($this->db->hasRows($userExists)) {
                return parent::ERR_USERNAME_EXISTS;
            }
        }

        // Existiert Email bereits? (momentane Email ausgeschlossen)
        if( $email != $this->getEmail()) {
            $mailExists = $this->db->selectRows( parent::DB_TABLE_USERS, "*", "email", $email );
            if($this->db->hasRows($mailExists)) {
                return parent::ERR_EMAIL_EXISTS;
            }
        }

        // TODO semester prüfen

        // Gültige Email-Adresse prüfen
        if(!filter_var( $email, FILTER_VALIDATE_EMAIL )) {
            return parent::ERR_EMAIL_INVALID;
        }

        // an Datenbank
        return $this->submitNameSettings( [$username, $vorname, $nachname, $email, $semester] );
    }

    public function validatePwSettings($oldPw, $newPw, $newPw2) {

        // Alle Felder ausgefüllt?
        if(!$this->checkIfEmpty( [$oldPw, $newPw, $newPw2] )) {
            return parent::ERR_EMPTY_INPUT;
        }

        // Altes (aktuelles) Passwort richtig?
        if(md5($oldPw) != $this->getPw()) {
            return parent::ERR_WRONG_OLD_PW;
        }

        // Passwörter stimmen nicht überein
        if($newPw != $newPw2) {
            return parent::ERR_PW_NOT_EQUAL;
        }

        // Neues Passwort mindestens 4 Zeichen (total sicher!!1eins)
        if(!$this->checkIfLength( [$newPw => 4] )) {
            return parent::ERR_INPUT_TOO_SHORT;
        }

        // an Datenbank
        return $this->submitPwSettings( $newPw );
    }

    private function submitNameSettings($dataArray) {
        $this->db->updateRow(
            parent::DB_TABLE_USERS,
            $this->getID(),
            [
                "username" => $dataArray[0],
                "vorname" => $dataArray[1],
                "nachname" => $dataArray[2],
                "email" => $dataArray[3],
                "semester" => $dataArray[4]
            ]
        );
        return false;
    }

    private function submitPwSettings($newPw) {
        $this->db->updateRow(
            parent::DB_TABLE_USERS,
            $this->getID(),
            [ "pass" => md5($newPw) ]
        );
        // TODO cookie neu schreiben, damit man nicht ausgeloggt wird ODER Nachricht, dass man sich neu einloggen muss

        return false;
    }
}
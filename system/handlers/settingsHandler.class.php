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

    function validateNameSettings($username, $vorname, $nachname, $email) {
        if(!$this->checkIfEmpty( array($username, $vorname, $nachname, $email) )) {
            return parent::ERR_EMPTY_INPUT;
        }

        return false;
    }

    function validatePwSettings($oldPw, $newPw, $newPw2) {
        if(!$this->checkIfEmpty( array($oldPw, $newPw, $newPw2) )) {
            return parent::ERR_EMPTY_INPUT;
        }

        return false;
    }
}
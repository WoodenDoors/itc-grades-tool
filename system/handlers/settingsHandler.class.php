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
        // ...
        return false;
    }

    function validatePwSettings($oldPw, $newPw, $newPw2) {
        // ...
        return false;
    }
}
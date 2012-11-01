<?php
/**
 * General PageHandler
 * Stellt gemeinsame Konstanten und Funktionen zur Verfügung
 *
 * @author mwegmann
 */
class pageHandler {
    // tables
    const DB_TABLE_USERS = "itc-grades-tool_users";

    // text
    const ERR_EMPTY_INPUT = "Bitte alle Felder ausfüllen.";
    const ERR_USERNAME_EXISTS = "Dieser Nutzername existiert bereits.";
    const ERR_EMAIL_EXISTS = "Es gibt bereits einen Nutzer mit dieser Email-Adresse.";
    const ERR_EMAIL_INVALID = "Keine akteptierte Email-Adresse.";
    const SUCCESS_REG = "Nutzer erfolgreich angelegt.";
    const ERR_INVALID_LOGIN = "Kein gültiges Login.";
    const ERR_INVALID_PASS = "Kein gültiges Passwort.";
    const ERR_QUERY_RETURNS_FALSE = "Da ist wohl ein Fehler mit der Datenbank passiert.";
    const ERR_INPUT_UNDERSIZED = "Alle Felder sollten mindestens 2 Zeichen lang sein.";


    protected function checkIfLogin() {
        if(isset($_COOKIE['username']) && isset($_COOKIE['pass'])) {
            // TODO: Continue here tomorrow
        }
    }

    protected function sanitizeOutput($string) {
        return htmlspecialchars($string);
    }

    protected function checkIfEmpty($input) {
        foreach($input as $item) {
            if($item == "") return false;
        }
        return true; // nur wahr wenn kein Item leer
    }

    protected function checkIfLength($input, $length) {
        foreach($input as $item) {
            if(strlen( $item) < $length ) return false;
        }
        return true;
    }
}

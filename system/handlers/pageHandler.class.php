<?php
/**
 * General PageHandler
 *
 * @author mwegmann
 */
class pageHandler {

    const ERR_EMPTY_INPUT = "Bitte alle Felder ausfüllen.";
    const ERR_USERNAME_EXISTS = "Dieser Nutzername existiert bereits.";
    const ERR_EMAIL_EXISTS = "Es gibt bereits einen Nutzer mit dieser Email-Adresse.";
    const ERR_EMAIL_INVALID = "Keine akteptierte Email-Adresse.";
    const SUCCESS_REG = "Nutzer erfolgreich angelegt.";
    const ERR_INVALID_LOGIN = "Kein gültiges Login.";
    const ERR_INVALID_PASS = "Kein gültiges Passwort.";
    const ERR_QUERY_RETURNS_FALSE = "Da ist wohl ein Fehler mit der Datenbank passiert.";

    protected function sanitizeOutput($string) {
        return htmlspecialchars($string);
    }

    protected function checkIfEmpty($input) {
        foreach($input as $item) {
            if($item == "") return false;
        }
        return true; // nur wahr wenn kein Item leer
    }
}

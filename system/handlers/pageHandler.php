<?php
/**
 * General PageHandler
 *
 * @author mwegmann
 */
class pageHandler {

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

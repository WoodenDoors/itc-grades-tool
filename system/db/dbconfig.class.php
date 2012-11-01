<?php
/**
 * Config für Datenbank
 * TODO: Ist das so sinvoll mit den Daten hier?
 * Vielleicht aus eigenener Datei einlesen, sodoass jeder andere Werte haben kann
 *
 * @author mwegmann
 */
class dbconfig {

    private $hostname;
    private $username;
    private $password;
    private $database;
	
    function __construct($hostname="localhost", $username="useritc", $password="itc2012", $database="ITC") {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function setDatabase($database) {
        $this->database = $database;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function setHostname($hostname) {
        $this->hostname = $hostname;
    }

    public function getHostname() {
        return $this->hostname;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }
}
?>

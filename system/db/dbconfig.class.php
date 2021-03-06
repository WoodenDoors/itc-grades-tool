<?php
/**
 * Config für Datenbank
 *
 * @author mwegmann
 */
class dbconfig {

    private $hostname;
    private $username;
    private $password;
    private $database;
	
    function __construct($hostname="localhost", $username="root", $password="", $database="ITC") {
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

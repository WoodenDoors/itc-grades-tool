<?php
/**
 * Config für Datenbank
 *
 * @author mwegmann
 */
class dbconfig {
    public $hostname;
    public $username;
    public $password;
    public $database;
	
    function __construct($hostname, $username, $password, $database) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }
}
?>

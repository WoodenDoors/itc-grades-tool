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
	
    function __construct($hostname="localhost", $username="useritc", $password="itc2012", $database="ITC") {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }
}
?>

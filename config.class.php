<?php
/**
 * Config für Datenbank
 *
 * @author mwegmann
 */
class config {
    public $hostname;
    public $username;
    public $password;
    public $database;
    public $prefix;
	
    function __construct($hostname, $username, $password, $database, $prefix, $type) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->prefix = $prefix;
    }
}
?>

<?php
/**
 * Description of registerHandler
 *
 * @author mwegmann
 */
require_once('database.class.php');

class registerHandler {
    private $db;
    private $username;
    private $vorname;
    private $nachname;
    private $email;
    private $pass;
    
    function __construct($username, $vorname, $nachname, $email, $pass) {
        $this->username = $username;
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->email = $email;
        $this->pass = $pass;
        
        $config = new config("localhost", "root", "", "itc", "");
        $this->db = new database($config);
        $this->db->openConnection();
    }
    
    function __destruct() {
        $this->db->closeConnection();
    }
    
    function validateInput() {
        if($this->username != "" ||
           $this->vorname != "" || 
           $this->nachname != "" ||
           $this->email != "" ||
           $this->pass != "") {
            return false;
        } else {
            return true;
        }
    }
    
    /* Einfacher Test */
    function testInput() {
        return $this->username ." - ".
            $this->vorname." - ".
            $this->nachname." - ".
            $this->email."- ".
            $this->pass;
    }
}

?>

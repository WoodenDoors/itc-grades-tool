<?php
/**
 * Handler for login.php
 *
 * @author Mathias
 */
require_once('../system/db/database.class.php');

class loginHandler {
    const DB_TABLE = "`itc-grades-tool_users`";
    
    const ERR_EMPTY_INPUT = "Bitte alle Felder ausfüllen.";
    
    private $db;
    private $login;
    private $pass;
    
    function __construct($login, $pass) {
        $this->login = $login;
        $this->pass = $pass;
        
        $config = new dbconfig();
        $this->db = new database($config);
        $this->db->openConnection();
    }
    
    function __destruct() {
        $this->db->closeConnection();
    }
    
    public function validateInput() {
        if(!$this->checkIfEmpty( array($this->login, $this->pass) )) {
            return self::ERR_EMPTY_INPUT;
        }
        
        return $this->login();
    }
    
    private function login() {
        return false;
    }
    
    private function checkIfEmpty($input) {
        foreach($input as $item) {
            if($item == "") return false;
        }
        return true; // nur wahr wenn kein Item leer
    }
}

?>

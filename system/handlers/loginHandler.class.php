<?php
/**
 * Handler for login.php
 *
 * @author Mathias
 */
require_once('../system/db/database.class.php');
require_once('../system/general/Constants.class.php');

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
        
        $query = $this->db->query(
                "SELECT * FROM " .self::DB_TABLE. 
                " WHERE `username` = '" .$this->sanitizeInput($this->login). "'");
        if($this->db->hasRows($query)) {
             return Constants::ERR_INVALID_LOGIN;
        }
        
        $result = $this->db->fetchAssoc($query);
        if(md5($this->pass) != $result['pass']) {
            return Constants::ERR_INVALID_PASS;
        }
        
        return $this->login();
    }
    
    private function login() {
        $hour = time() + 302400;
        setcookie(username, $_POST['username'], $hour);
        setcookie(pass, $_POST['pass'], $hour);

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

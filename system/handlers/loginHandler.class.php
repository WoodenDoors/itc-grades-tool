<?php
/**
 * Handler for login.php
 *
 * @author Mathias
 */
require_once('pageHandler.class.php');
require_once('../system/db/database.class.php');

class loginHandler extends pageHandler {
    const DB_TABLE = "itc.`itc-grades-tool_users`";
    
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
            return parent::ERR_EMPTY_INPUT;
        }

        $sql=
            "SELECT * FROM `itc-grades-tool_users` WHERE `username` = '.Mathes.'";
           // "SELECT * FROM " .self::DB_TABLE. " WHERE `username` = '" .$this->sanitizeInput($this->login). "'";
        ;

        if(!$query = $this->db->query($sql)) {
            return parent::ERR_QUERY_RETURNS_FALSE;
        }

        if($this->db->countRows($query) > 0) {
             return parent::ERR_INVALID_LOGIN." - ".$this->db->countRows($query);
        }

        $result = $this->db->fetchAssoc($query);
        if(md5($this->pass) != $result['pass']) {
            return parent::ERR_INVALID_PASS;
        }


        return false;
        //return $this->login();
    }

    private function login() {
        $hour = time() + 302400;
        setcookie("username", "a", $hour);
        setcookie("pass", "b", $hour);

        return false;
    }
    
    private function sanitizeInput($string) {
        return $this->db->escapeString($string);
    }
}

?>

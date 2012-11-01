<?php
/**
 * Handler for login.php
 *
 * @author Mathias
 */
require_once('pageHandler.class.php');
require_once('../system/db/database.class.php');

class loginHandler extends pageHandler {
    
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
    
    function __destruct() { }
    
    public function validateInput() {
        if(!$this->checkIfEmpty( array($this->login, $this->pass) )) {
            return parent::ERR_EMPTY_INPUT;
        }

        // First Test Username
        $testUsername = $this->db->selectRows("*", parent::DB_TABLE_USER, "username", $this->login);
        if(!$this->db->hasRows($testUsername)) {
        // Then Test Email
            $testEmail = $this->db->selectRows("*", parent::DB_TABLE_USER, "email", $this->login);
            if(!$this->db->hasRows($testEmail)) {
                return parent::ERR_INVALID_LOGIN;
            }
        }

        $result = $this->db->fetchAssoc($testUsername);
        if(md5($this->pass) != $result['pass']) {
            return parent::ERR_INVALID_PASS;
        }

        return $this->login($result); // send to login function
    }

    private function login($result) {
        $hour = time() + 302400;
        setcookie("username", $result['username'], $hour);
        setcookie("pass", $result['pass'], $hour);

        return false; // everything ok
    }
}

?>

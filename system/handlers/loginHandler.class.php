<?php
/**
 * Handler for login.php
 *
 * @author mwegmann
 */
require_once('pageHandler.class.php');

class loginHandler extends pageHandler {

    private $login;
    private $pass;
    
    function __construct($login, $pass) {
        $this->login = $login;
        $this->pass = $pass;

        parent::__construct();
    }
    
    function __destruct() { }
    
    public function validateInput() {
        if(!$this->checkIfEmpty( array($this->login, $this->pass) )) {
            return parent::ERR_EMPTY_INPUT;
        }

        // Erst Username testen
        $testUsername = $this->db->selectRows(parent::DB_TABLE_USERS, "*", "username", $this->login);
        if(!$this->db->hasRows($testUsername)) {
        // Dann Email Testen
            $testEmail = $this->db->selectRows(parent::DB_TABLE_USERS, "*", "email", $this->login);
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

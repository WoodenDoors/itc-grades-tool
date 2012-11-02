<?php
/**
 * Handler for login.php
 *
 * @author mwegmann
 */
require_once('pageHandler.class.php');

class loginHandler extends pageHandler {

    function __construct() {
        parent::__construct();
    }
    
    function __destruct() { }
    
    public function validateInput($login, $pass) {

        if(!$this->checkIfEmpty( array($login, $pass) )) {
            return parent::ERR_EMPTY_INPUT;
        }

        // Erst Username testen
        $testUsername = $this->db->selectRows(parent::DB_TABLE_USERS, "*", "username", $login);
        if(!$this->db->hasRows($testUsername)) {
        // Dann Email Testen
            $testEmail = $this->db->selectRows(parent::DB_TABLE_USERS, "*", "email", $login);
            if(!$this->db->hasRows($testEmail)) {
                return parent::ERR_INVALID_LOGIN;
            }
        }

        $result = $this->db->fetchAssoc($testUsername);
        if(md5($pass) != $result['pass']) {
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

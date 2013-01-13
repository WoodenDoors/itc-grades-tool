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
        $query = $this->db->selectRows(parent::DB_TABLE_USERS, "*", "username", $login);
        if(!$this->db->hasRows($query)) {
        // Dann Email Testen
            $query = $this->db->selectRows(parent::DB_TABLE_USERS, "*", "email", $login);
            if(!$this->db->hasRows($query)) {
                return parent::ERR_INVALID_LOGIN;
            }
        }
        $result = $this->db->fetchAssoc($query);
        if(md5($pass) != $result[0]['pass']) {
            return parent::ERR_INVALID_PASS;
        }
        return $this->login($result[0]); // send to login function
    }

    private function login($result) {
        $hour = time() + 302400;
        setcookie("username", $result['username'], $hour);
        setcookie("pass", $result['pass'], $hour);

        return false; // everything ok
    }
}

?>

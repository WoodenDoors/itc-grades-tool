<?php
/**
 * DB Verbindung und Query Befehle etc.
 *
 * @author mwegmann
 */
require_once('dbconfig.class.php');

class database {
    private $config;
    private $connection;
    private $db;
    
    function __construct($config) {
        $this->config = $config;
    }
    
    /* Mit DB verbinden */
    public function openConnection() {
	try {
            $this->connection = mysqli_connect($this->config->hostname, $this->config->username, $this->config->password);
            $this->connection->set_charset("utf8");
            $this->db = mysqli_select_db($this->connection, $this->config->database);
	} catch(exception $e){
            return $e;
	}
    }
    
    /* Verbindung schließen */
    public function closeConnection() {
        try {
            mysqli_close($this->connection);
        } catch (exception $e) {
            return $e;
        }
    }
    
    /* Einfacher Ping-Test */
    public function testServerConnection() {
        try {
            if (!mysqli_ping($this->connection)) {
                return false;
            } else {
                return true;
            }
        } catch (exception $e) {
            return $e;
        }
    }
    
    /* addslashes und mysqli_real_escape_string */
    public function escapeString($string) {
        return mysqli_real_escape_string($this->connection, addslashes($string) );
    }
    
    /* DB-Query */
    public function query($query) {
        try {
            $this->openConnection();
            return mysqli_query( $this->connection, $this->escapeString($query) );
            $this->closeConnection();
            
        } catch (exception $e) {
            return $e;
        }
    }
    

    /* Prüft ob Reihen überhaupt vorhanden */
    public function hasRows($result) {
        try {
            if( mysqli_num_rows($result) > 0 ) {
                return true;
            } else {
                return false;
            }
        } catch (exception $e) {
            return $e;
        }
    }

    /* Gibt Anzahl Reihen aus */
    public function countRows($result) {
        try {
            return mysqli_num_rows($result);
        } catch (exception $e) {
            return $e;
        }
    }

    /* Assoziativer Arrray mit Ergebnissen */
    public function fetchAssoc($result) {
        try {
            return mysqli_fetch_assoc($result);
        } catch (exception $e) {
            return $e;
        }
    }

}
?>

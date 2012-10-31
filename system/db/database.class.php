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
        $this->connection = new mysqli(
            $this->config->getHostname(),
            $this->config->getUsername(),
            $this->config->getPassword(),
            $this->config->getDatabase()
        );
        $this->connection->set_charset("utf8");
        if($this->connection->connect_errno) {
            die($this->connection->connect_error());
        }
    }
    
    /* Verbindung schließen */
    public function closeConnection() {
        try {
            mysqli_close($this->connection);
        } catch (exception $e) {
            die($this->connection->error());
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
            die($this->connection->error());
        }
    }
    
    /* addslashes und mysqli_real_escape_string */
    public function escapeString($string) {
        return $this->connection->real_escape_string( addslashes($string) );
    }
    
    /* DB-Query */
    public function query($query) {
        try {
            if(empty($this->connection)) {
                $this->openConnection();
                $result = $this->connection->query( $this->escapeString($query) );
                $this->closeConnection();
                return $result;

            } else {
                return $this->connection->query( $this->escapeString($query) );
            }
        } catch (exception $e) {
            die($this->connection->error());
        }
    }
    

    /* Prüft ob Reihen überhaupt vorhanden */
    public function hasRows($result) {
        try {
            if( $result->num_rows() > 0 ) {
                return true;
            } else {
                return false;
            }
        } catch (exception $e) {
            die($this->connection->error());
        }
    }

    /* Gibt Anzahl Reihen aus */
    public function countRows($result) {
        try {
            return $result->num_rows();
        } catch (exception $e) {
            die($this->connection->error());
        }
    }

    /* Assoziativer Arrray mit Ergebnissen */
    public function fetchAssoc($result) {
        try {
            return $result->fetch_assoc();
        } catch (exception $e) {
            die($this->connection->error());
        }
    }

}
?>

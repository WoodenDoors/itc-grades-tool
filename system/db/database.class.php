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
    
    function __construct($config) {
        $this->config = $config;
        $this->openConnection();
    }

    function __destruct() {
        $this->closeConnection();
    }

    /* Mit DB verbinden */
    public function openConnection() {
        try {
            $this->connection = new mysqli(
                $this->config->getHostname(),
                $this->config->getUsername(),
                $this->config->getPassword(),
                $this->config->getDatabase()
            );

            $this->connection->set_charset("utf8");
        } catch (exception $e) {
            die($this->connection->connect_error());
        }
    }
    
    /* Verbindung schließen */
    public function closeConnection() {
        try {
            if(!empty($this->connection)) {
                $this->connection->close();
            }
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
        return $this->connection->real_escape_string( addslashes( $string ) );
    }
    
    /* DB-Query */
    private function query($query) {
        try {
            if(empty($this->connection)) {
                $this->openConnection();
                $result = $this->connection->query( $query );
                $this->closeConnection();
                return $result;

            } else {
                return $this->connection->query( $query );
            }
        } catch (exception $e) {
            die($this->connection->error());
        }
    }

    /* Einfacher SQL Select */
    public function selectRows( $table, $rows="*", $whereField=NULL, $whereInput=NULL ) {
        $sql = "SELECT ".$rows." FROM `".$table."` ";
        if( !is_null( $whereField ) && !is_null( $whereInput ) ) {
            $sql .= "WHERE `".$whereField."` = '".$this->escapeString( $whereInput )."'";
        }

        if(!$result = $this->query($sql)) {
            die("Invalid Query");
            //die("Invalid Query:" .$sql);
        }
        return $result;
    }

    /* Einfacher SQL Insert */
    public function insertRow($table, $values, $rows=NULL) {
        $sql = "INSERT INTO `".$table."` ";
        if(!is_null($rows)) {
            $sql .= "(". $rows .") ";
        }
        for( $i=0; $i < count( $values ); $i++ ) {
            $values[$i] = "'". $this->escapeString( $values[$i] ) ."'";
        }
        $sql .= "VALUES (". implode(', ', $values). ")";

        if(!$result = $this->query($sql)) {
            die("Invalid Query");
            //die("Invalid Query:" .$sql);
        }
        return $result;
    }

    /* Prüft ob Reihen überhaupt vorhanden */
    public function hasRows($result) {
        try {
            if( $result->num_rows > 0 ) {
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
            return $result->num_rows;
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

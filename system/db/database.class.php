<?php
/**
 * DB Verbindung und Query Befehle etc.
 * Wenn irgendwas nicht funktioniert einfach die "die("Invalid Query:" .$sql)" einschalten
 * weil zu faul für debug-Modus
 * Auf Produktion sollen die aber wieder raus
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
    public function selectRows( $table, $rows="*", $whereField=NULL, $whereInput=NULL) {
        //if($rows != "*") $rows = "`". $rows . "`";
        $sql = "SELECT ".$rows." FROM `".$table."` ";
        if( !is_null( $whereField ) && !is_null( $whereInput ) ) {
            if( !is_array($whereField) ) {
                $sql .= "WHERE `".$whereField."` = '".$this->escapeString( $whereInput )."'";

            // Mehrere WHERE-Conditions
            } else {
                $whereLength = count($whereField);
                if( !is_array($whereInput) || ( count($whereInput) != $whereLength) ) { die("Invalid WHERE Syntax."); }
                for( $i=0; $i < $whereLength; $i++ ){
                    $keyword = ($i == 0) ? "WHERE" : " AND";
                    $sql .= $keyword." `".$whereField[$i]."` = '".$this->escapeString( $whereInput[$i] )."'";
                }
            }
        }

        if(!$result = $this->query($sql)) {
            //die("Invalid Query");
            die("Invalid Query:" .$sql);
        }
        return $result;
    }

    /* Einfacher SQL Insert */
    public function insertRow($table, $values, $rows=NULL) {
        $sql = "INSERT INTO `".$table."` ";
        if( !is_null($rows) ) {
            $sql .= "(". $rows .") ";
        }
        for( $i=0; $i < count( $values ); $i++ ) {
            $values[$i] = "'". $this->escapeString( $values[$i] ) ."'";
        }
        $sql .= "VALUES (". implode(', ', $values). ")";

        if(!$result = $this->query($sql)) {
            //die("Invalid Query");
            die("Invalid Query:" .$sql);
        }
        return $result;
    }


    /* Einfacher SQL Update */
    public function updateRow($table, $id, $update) {
        $sql = "UPDATE `". $table ."` ";

        $i=0;
        $arraySize = count($update);
        $sql .= "SET ";
        foreach($update as $key => $value) {
            $sql .= "`". $key ."` = '".$this->escapeString( $value )."'";
            if($i != $arraySize-1) { $sql .=", "; } // Komma hinter jeder Angabe (außer der letzten)
            $i++;
        }
        $sql .= "WHERE `". $table ."`.`ID` =".$id." ";

        if(!$result = $this->query($sql)) {
            //die("Invalid Query");
            die("Invalid Query:" .$sql);
        }
    }

    public function getInsertID() {
        return $this->connection->insert_id;
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
            while($row = $result->fetch_assoc()) {
                $array[] = $row;
            }
            return $array;
        } catch (exception $e) {
            die($this->connection->error());
        }
    }

}
?>

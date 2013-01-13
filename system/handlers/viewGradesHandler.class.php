<?php
/*
 * Handler class for viewGrades page
 * @author szier
 */

require_once 'pageHandler.class.php';
class viewGradesHandler extends pageHandler{
    function __construct(){
        parent::__construct();
    }
    
    function hasGrades($pUser){
        $UserID = parent::getUserID($pUser);

        $query = $this->db->selectRows(parent::DB_TABLE_GRADES, '*', 'user_id', $UserID);
        if ($this->db->hasRows($query)){
            return true;
        }
        else return false;
    }
    
   function getGrades($pUser){
        $pUser = parent::getUserID($pUser);

        $query = $this->db->selectRows(parent::DB_TABLE_GRADES, '*', 'user_id', $pUser);
        $noOfRows = $this->db->countRows($query);
        $grades = $this->db->fetchAssoc($query);

        //Fächer werden mit Kürzel ausgelesen
        for($i=0; $i<$noOfRows; $i++){
            $query = $this->db->selectRows(
                parent::DB_TABLE_COURSES,
                'abbreviation',
                'ID',
                $grades[$i]['course_id']
            );
            $course = $this->db->fetchAssoc($query);

            // Ergebnis in Ausgabearray speichern
            $result[] = [
                'abbreviation' => $course[0]['abbreviation'],
                'grade' => $grades[$i]['grade']
            ];
        }
       return $result;
    }
}
?>

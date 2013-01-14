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
    
    function hasGrades(){
        $query = $this->db->selectRows(parent::DB_TABLE_GRADES, '*', 'user_id', $this->getID());
        if ($this->db->hasRows($query)){
            return true;
        }
        else return false;
    }
    
   function getGrades(){
        $query = $this->db->selectRows(parent::DB_TABLE_GRADES, '*', 'user_id', $this->getID());
        $noOfRows = $this->db->countRows($query);
        $grades = $this->db->fetchAssoc($query);

        //Fächer werden mit Kürzel ausgelesen
        for($i=0; $i<$noOfRows; $i++){
            $query = $this->db->selectRows( parent::DB_TABLE_COURSES, '*', 'ID', $grades[$i]['course_id'] );
            $course = $this->db->fetchAssoc($query);

            // Ergebnis in Ausgabearray speichern
            $result[] = [
                'semester' => $course[0]['semester'],
                'abbreviation' => $course[0]['abbreviation'],
                'course' => $course[0]['course'],
                'credits' => $course[0]['credits'],
                'grade' => $grades[$i]['grade']
            ];
        }
       return $result;
    }
}
?>

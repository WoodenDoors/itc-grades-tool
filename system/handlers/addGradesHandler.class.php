<?php
/*
 * Handler class for addGrades page
 * @author szier
 */
require_once('pageHandler.class.php');

class addGradesHandler extends pageHandler {

    function __construct() {
        parent::__construct();
    }

    function getCourseID($pCourse){
        $query = $this->db->selectRows(parent::DB_TABLE_COURSES, 'ID', 'abbreviation', $pCourse);
        return $this->db->fetchAssoc($query)[0]['ID'];
    }

    function getCourses($semester=NULL){
        if($semester==NULL) $semester = $this->getSemester();

        $query = $this->db->selectRows(parent::DB_TABLE_COURSES, 'abbreviation, course', 'semester', $semester);
        return $this->db->fetchAssoc($query);
    }


    function validateGrades($pGrade, $pCourse){
        if( ($pGrade<1.0) || ($pGrade>6.0) ){
            return false;
        }
        $courseID = $this->getCourseID($pCourse);
        $query = $this->db->selectRows(
            parent::DB_TABLE_GRADES, '*',
            ['user_id', 'course_id'],
            [$this->getID(), $courseID]
        ); //Überprüfung, ob Datensatz vorhanden

        if(!$this->db->hasRows($query)){ //Einfügen nur, wenn für das Fach noch keine Note des Nutzers eingetragen ist
            $this->submitGrades($pGrade, $courseID);
            return false;
        } else return false;
        // TODO Lieber nur eine Warnung bzw. ein "Wirklich ändern?" anzeigen
    }

    private function submitGrades($grade, $courseID){
        $this->db->insertRow(
            parent::DB_TABLE_GRADES,
            [$this->getID(), $courseID, $grade ],
            'user_id, course_id, grade'
        );
    }

}
?>

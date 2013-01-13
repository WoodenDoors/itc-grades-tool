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
   // function submitGrades(){
        
   //     $this->db->insertRows('itc-grades-tool_grades', $course, $grade);
   //     return false;            
   // }
    function getCourseID($pCourse){
        $query = $this->db->selectRows(parent::DB_TABLE_COURSES, 'course_id', 'abbreviation', $pCourse);
        return $this->db->fetchAssoc($query);
    }

    function getCourses($semester=NULL){
        if($semester==NULL) $semester = $this->getSemester();

        $query = $this->db->selectRows(parent::DB_TABLE_COURSES, 'abbreviation, course', 'semester', $semester);
        return $this->db->fetchAssoc($query);
    }


    function validateGrades($pUserID, $pGrade, $pCourse){
        
        if( ($pGrade<1.0) || ($pGrade>6.0) ){
            return true;
        }
        //Überprüfung, ob Datensatz vorhanden
        $query=$this->db->selectRows( parent::DB_TABLE_GRADES, '*', ['user_id', 'course_id'], [$pUserID, $pCourse] );
        
        //Einfügen nur, wenn für das Fach noch keine Note des Nutzers eingetragen ist
        IF (!hasRows($query)){
            $this->db->insertRow( parent::DB_TABLE_GRADES, [$pUserID, $pGrade, $pCourse], "user_id, grade, course_id");
            return false;
        }
    }
}
?>

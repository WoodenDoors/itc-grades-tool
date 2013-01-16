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

    function validateGrades($pGrade, $pCourse, $pEdit){
        $courseID = $this->getCourseID($pCourse);

        $error = $this->checkGradeFormat($pGrade);
        if($error !== true) {
            return $error;
        }

        //Überprüfung, ob Datensatz vorhanden
        $query = $this->db->selectRows(
            parent::DB_TABLE_GRADES, '*',
            ['user_id', 'course_id'],
            [$this->getID(), $courseID]
        );

        if($this->db->hasRows($query)&&!$pEdit){
            return parent::ERR_GRADE_ALREADY_EXISTS;
        }
        //Update, wenn Daten vorhanden und Haken gesetzt
        if($this->db->hasRows($query)&&$pEdit){
           $gradeID = $this->db->selectRows(
                   parent::DB_TABLE_GRADES,'ID',
                   ['user_id', 'course_id'],
                   [$this->getID(), $courseID]);
           $gradeID = $this->db->fetchAssoc($gradeID);
           $this->db->updateRow(
                parent::DB_TABLE_GRADES,
                $gradeID[0],[
                  'user_id' => $this->getID(),
                  'course_id' => $courseID,
                  'grade' => $pGrade] 
            );
            return true;
        }
        //Einfügen nur, wenn für das Fach noch keine Note des Nutzers eingetragen ist
        return $this->submitGrades($pGrade, $courseID);
    }

    private function submitGrades($grade, $courseID){
        $this->db->insertRow(
            parent::DB_TABLE_GRADES,
            [$this->getID(), $courseID, $grade ],
            'user_id, course_id, grade'
        );
        return true;
    }

}
?>

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

    function validateGrades($pGrade, $pCourse){
        $courseID = $this->getCourseID($pCourse);

        $error = $this->checkGradeFormat($pGrade);
        if($error !== true) {
            return $error;
        }

        //Überprüfung, ob Datensatz vorhanden
        // TODO: Lieber nur eine Warnung bzw. ein "Wirklich ändern?" anzeigen
        $query = $this->db->selectRows(
            parent::DB_TABLE_GRADES, '*',
            ['user_id', 'course_id'],
            [$this->getID(), $courseID]
        );

        if($this->db->hasRows($query)){
            return parent::ERR_GRADE_ALREADY_EXISTS;
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

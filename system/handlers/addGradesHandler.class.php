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

        if(parent::checkGradesFormat($pGrade)){

            //Überprüfung, ob Datensatz vorhanden
            // TODO: Lieber nur eine Warnung bzw. ein "Wirklich ändern?" anzeigen
            $query = $this->db->selectRows(
                parent::DB_TABLE_GRADES, '*',
                ['user_id', 'course_id'],
                [$this->getID(), $courseID]
            );
            if($this->db->hasRows($query)){
                return parent::ERR_GRADE_ALREADY_EXISTS;
            } else {

                //Einfügen nur, wenn für das Fach noch keine Note des Nutzers eingetragen ist
                $this->submitGrades($pGrade, $courseID);
                return true;
            }
        }




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

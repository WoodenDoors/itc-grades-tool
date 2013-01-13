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
        $courseID = $this->getCourseID($pCourse);

        // Note zwischen 1.0 und 5.0
        if( ( $pGrade<1.0 ) || ( $pGrade>5.0 ) ){
            return parent::ERR_GRADES_WRONG_SYNTAX;
        }

        // Note darf nur bestimmte Werte
        $validGrades = [ 1.0, 1.3, 1.7, 2, 2.3, 2.7, 3.0, 3.3, 3.7, 4.0, 5.0 ];
        // Quellen: https://www-sec.uni-regensburg.de/pnz/index.html.de || http://www.uni-passau.de/4937.html || http://de.wikipedia.org/wiki/Schulnote#Hochschule
        // TODO: Prüfung

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

    private function submitGrades($grade, $courseID){
        $this->db->insertRow(
            parent::DB_TABLE_GRADES,
            [$this->getID(), $courseID, $grade ],
            'user_id, course_id, grade'
        );
    }

}
?>

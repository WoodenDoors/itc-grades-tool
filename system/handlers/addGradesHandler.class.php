<?php

/*
 * Handler class for addGrades page
 * @author szier
 */
require_once('pageHandler.class.php');

class addGradesHandler extends pageHandler {
    private $course;
    private $grade;
    function __construct() {
        parent::__construct();
    }
   // function submitGrades(){
        
   //     $this->db->insertRows('itc-grades-tool_grades', $course, $grade);
   //     return false;            
   // }
    function getCourseID($pCourse){
        $query = $this->db->selectRows('itc-grades-tool_courses','CourseID','Abbrevation',$pCourse);
        return $this->db->fetchAssoc($query);
    }
    
    function getUserID($pUser){
        $query = $this->db->selectRows('itc-grades-tool_users','ID','username',$pUser);
        return $this->db->fetchAssoc($query);
    }
    function validateGrades($pUserID,$pGrade,$pCourse){
        
        if(($pGrade<1.0)||($pGrade>6.0)){
            return true;
        }
        //$this->submitGrades();
        $this->db->insertRow('itc-grades-tool_grades', [$pUserID, $pGrade, $pCourse],"UserID, grade, CourseID");
        return false;
    }
}
?>

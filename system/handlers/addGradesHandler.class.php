<?php

/*
 * Handler class for addGrades page
 * @author szier
 */
require_once('pageHandler.class.php');

class addGradesHandler extends pageHandler {
    private $subject;
    private $grade;
    function __construct() {
        parent::__construct();
    }
    function submitGrades(){
        if (checkIfLogin()){
            insertRows('itc-grades-tool_grades', $subject, $grade);
            return false;            
        }
    }
    function validateGrades(){
        /*
         * $subjekt und $grade werden 
         * aus dem form gefüllt
         */
        if(($grade<1.0)||($grade>6.0)){
            return false;
        }
        submitGrades();
    }
}
?>

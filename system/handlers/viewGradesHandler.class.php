<?php

/*
 *handler class for viewGrades page
 *@author szier
 */
require_once 'pageHandler.class.php';
class viewGradesHandler extends pageHandler{
    function __construct(){
        parent::__construct();
    }
    
    function hasGrades($pUser){
        $UserID=parent::getUserID($pUser);
        $query=$this->db->selectRows('itc-grades-tool_grades','*','UserID',$UserID);
        if (hasrows($query)){
            exit(true);
        }
        else exit(false);
    }
}
?>

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
        $UserID= parent::getUserID($pUser);
        $query= $this->db->selectRows('itc-grades-tool_grades','*','UserID',$UserID);
        if (hasrows($query)){
            return true;
        }
        else   return false;
    }
    
   function getGrades($pUser, &$pString){
        $pUser= parent::getUserID($pUser);
        $query= $this->db->selectRows('itc-grades-tool_grades','*','UserID',$pUser);
        $noOfRows= $this->db->countRows($query);
        $query= $this->db->fetchAssoc($query);
        
        //Fächer werden mit Kürzel ausgelesen
        for($i=0;$noOfRows;$i++){
            $course= $this->db->selectRows(
                    'itc-grades-tool_courses','Abbrevation',$query['CourseID'][$i],$pUser);
            $course= $this->db->fetchAssoc($course);
            $pString.= "<tr><td>$course<td>
                        <td>".$query['grade'][$i]."</td></tr>";
        }
            
    }
}
?>

<?php
/**
 * Handler for projects.php
 *
 * @author mwegmann
 */
require_once('pageHandler.class.php');
class projectsHandler  extends pageHandler {
    function __construct() {
        parent::__construct();
    }

    function __destruct() { }

    private function addProject($name, $text, $course, $grade=NULL, $party=NULL){
        $courseID = $this->getCourseID($course);

        if( $grade==NULL ) $grade = 0.0;
        $party = [ [ 'ID' => $this->getID() ] ]; // TODO use forwarded party data
        $this->submitProject($name, $text,  $courseID, $grade, $party);
    }

    private function getCourseID($abbreviation){
        $query = $this->db->selectRows(parent::DB_TABLE_COURSES, 'ID', 'abbreviation', $abbreviation);
        return $this->db->fetchAssoc($query)[0]['ID'];
    }

    private function submitProject($name, $text, $courseID, $grade, $party) {
        $this->db->insertRow(
            parent::DB_TABLE_PROJECTS,
            [$courseID, $grade, $name, $text],
            ['course_id', 'grade', 'name', 'text']
        );
        $projectID = $this->db->getInsertID();

        foreach($party as $person) {
            $this->db->insertRow(parent::DB_TABLE_PROJECT_PARTY, [ $projectID, $person['ID'] ]);
        }
    }

    function editProjectText($id) {
        /// TODO
    }

    function getOneProject($projectID) {
        $query = $this->db->selectRows(parent::DB_TABLE_PROJECTS, '*', 'ID', $projectID);
        $project = $this->db->fetchAssoc($query);

        $query = $this->db->selectRows(parent::DB_TABLE_COURSES, '*', 'ID', $project[0]['course_id']);
        $course = $this->db->fetchAssoc($query);

        $party = $this->getParty($project[0]['ID']);

        $result = [
            'ID' => $project[0]['ID'],
            'course' => $course[0]['abbreviation'],
            'participants' => $party,
            'name' => $project[0]['name'],
            'text' => $project[0]['text'],
            'grade' => $project[0]['grade']
        ];
        return $result;
    }

    private function getParty($projectID) {
        $query = $this->db->selectRows(parent::DB_TABLE_PROJECT_PARTY, '*', 'project_id', $projectID);
        if( $this->db->countRows($query) == 1) {
            return "Einzelprojekt";
        }
        $party = $this->db->fetchAssoc($query);

        $party_string = '';
        $i=0;
        foreach($party as $person) {
            $query = $this->db->selectRows(parent::DB_TABLE_USERS, '*', 'ID', $person['user_id']);
            $user = $this->db->fetchAssoc($query);

            if( $i>0 ) $party_string .= ', ';
            $party_string .= $user[0]['username'];
            $i++;
        }
        return $party_string;
    }

    function getAllProjects() {
        $query = $this->db->selectRows(parent::DB_TABLE_PROJECT_PARTY, 'project_id', 'user_id', $this->getID());
        if( !$this->db->hasRows($query) ) {
            return "Keine Projekte vorhanden."; // TODO Error Msg ergänzen
        }
        $projectIDs = $this->db->fetchAssoc($query);

        foreach($projectIDs as $projectID) {
            $project = $this->getOneProject($projectID['project_id']);
            $result[] = $project;
        }
        return $result;
    }
}
?>
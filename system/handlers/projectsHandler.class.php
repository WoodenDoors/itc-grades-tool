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

    function addProject() {
        // TODO
    }

    function editProjectText($id) {
        /// TODO
    }

    function getOneProject($projectID) {
        $query = $this->db->selectRows(parent::DB_TABLE_PROJECTS, '*', 'ID', $projectID);
        $project = $this->db->fetchAssoc($query);

        $result = [
            'course' => 'GDI41', // TODO query course name
            'participants' => 'Einzelprojekt', // TODO query other participants
            'name' => $project[0]['name'],
            'text' => $project[0]['text'],
            'grade' => $project[0]['grade']
        ];
        return $result;
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
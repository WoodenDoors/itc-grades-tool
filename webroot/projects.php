<?php
require_once('../system/handlers/projectsHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new projectsHandler();
$login = $handler->checkIfLogin();
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
function viewAll($handler, $page, &$content) {
    $projects = $handler->getAllProjects();

    $prNr=1;
    $projects_string='';
    foreach($projects as $project) {
        $grade = ($project['grade'] == 0.0) ? "nicht bewertet" : $project['grade'];
        $projects_string .= '<tr>
                <td>' .$prNr. '</td>
                <td title="' .$project['course']. '">' .$project['course_abbreviation']. '</td>
                <td>' .$project['participants']. '</td>
                <td>' .$project['name']. '</td>
                <td>' .$grade. '</td>
                <td><a href="projects.php?page=show&id=' .$project['ID']. '">Details</a></td>
            </tr>';
        $prNr++;
    }

    $content .= $page->loadAdditionalTemplate(
        "projects_view",
        [
            "PROJECTS_DATA" => $projects_string,
            "REQUEST_URI" => $_SERVER['REQUEST_URI']
        ]
    );
}
//------------------------------------------------------------------------------------------------------------------

function show($handler, $page, &$content, $projectID) {
    $project = $handler->getOneProject($projectID);
    if($project === false) {
        $content .= "Projekt existiert nicht.";
    } else {

        //$content .= '<div name="pText" id="pText" contenteditable="true">' .$project['text']. "</div>";

        $content .= $page->loadAdditionalTemplate(
            "project_show",
            [
                "PROJECT_ID" => $project['ID'],
                "COURSE_NAME" => $project['course'],
                "PROJECT_NAME" => $project['name'],
                "PROJECT_GRADE" => $project['grade'],
                "PROJECT_TEXT" => $project['text'],
                "REQUEST_URI" => $_SERVER['REQUEST_URI']
            ]
        );

    }

}

//------------------------------------------------------------------------------------------------------------------
function add($handler, $page, &$content) {
    $semester = $handler->getSemester();
    $display_semester = (isset($_GET["semester"]) && ($_GET['semester'] <= $semester))
        ? $_GET["semester"]
        : $semester;

    $semester_string = "";
    for($i=1; $i<=$semester; $i++){
        $selected = ($display_semester == $i) ? ' selected="selected"' : '';
        $semester_string .= '<option value="' . $i . '"'.$selected.'>' . $i . '. Semester</option>';
    }

    $courses = $handler->getCourses($display_semester);
    $all_grades = '';
    foreach ($courses as $course) {
        $all_grades .= '<option value="' . $course['abbreviation'] . '">' . $course['course'] . '</option>
        ';
    }

    $content .= $page->loadAdditionalTemplate(
        "project_add",
        [
            "ALL_GRADES" => $all_grades,
            "ALL_SEMESTERS" => $semester_string,
            "REQUEST_URI" => $_SERVER['REQUEST_URI']
        ]
    );
}
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------

//neue Seite
//------------------------------------------------------------------------------------------------------------------
$page = new page();
$content = '';
if (!$login){
    $content .= $page->buildResultMessage("errorMsg", "Sie sind nicht eingeloggt! Bitte einloggen.");
} else{
//------------------------------------------------------------------------------------------------------------------

    if(isset($_POST['submitAdd'])) {
        $submit = $handler->addProject($_POST['pName'], $_POST['pText'], $_POST['course']);
        if ($submit === true) {
            $content .= $page->buildResultMessage(
                "successMsg",
                "Projekt '".$_POST['pName']."' erfolgreich hinzugefügt."
            );
        } else {
            $content .= $page->buildResultMessage("errorMsg", $submit);
        }
    }
    if(isset($_POST['submitShow'])) {
        $submit = $handler->editProject($_POST['pID'], $_POST['grade'], $_POST['pName'], $_POST['pText']);
        if ($submit === true) {
            $content .= $page->buildResultMessage(
                "successMsg",
                "Projekt '".$_POST['pName']."' erfolgreich geändert."
            );
        } else {
            $content .= $page->buildResultMessage("errorMsg", $submit);
        }
    }
//------------------------------------------------------------------------------------------------------------------
    $subPage = ( !isset($_GET['page']) ) ? "viewAll" : $_GET['page'];
    switch( $subPage ) {
        case "show":
            show($handler, $page, $content, $_GET['id']);
            break;
        case "add":
            add($handler, $page, $content);
            viewAll($handler, $page, $content);
            break;
        case "addstrip":
            add($handler, $page, $content);
            break;
        case "view":
        default:
            // TODO: vielleicht standartmäßig "add" dazuladen und beim klick via jquery runterfahren?
            viewAll($handler, $page, $content);
    }

}
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
?>

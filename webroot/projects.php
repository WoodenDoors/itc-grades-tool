<?php
require_once('../system/handlers/projectsHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new projectsHandler();
$login = $handler->checkIfLogin();
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
function viewAll($handler, $page, &$content) {
    $projects = $handler->getAllProjects();

    // TODO das soll natürlich später nicht mehr so hässlich mit Tabellen aussehen, das ist nur ein Test
    $content .= '<a href="'.$_SERVER['REQUEST_URI'].'?page=add">Hinzufügen</a>';
    $content .= '<table>';
    $content .= '
        <tr>
            <th>Projekt</th>
            <th>Kurs</th>
            <th>Teilnehmer</th>
            <th>Name</th>
            <th>Note</th>
            <th></th>
        </tr>';

    $prNr=1;
    foreach($projects as $project) {
        $grade = ($project['grade'] == 0.0) ? "nicht bewertet" : $project['grade'];
        $content .= "<tr>
                <td>" .$prNr. "</td>
                <td>" .$project['course']. "</td>
                <td>" .$project['participants']. "</td>
                <td>" .$project['name']. "</td>
                <td>" .$grade. '</td>
                <td><a href="projects.php?page=show&id=' .$project['ID']. '">more</a></td>
            </tr>';
        $prNr++;
    }

    $content .= '</table>';
}
//------------------------------------------------------------------------------------------------------------------

function show($handler, $page, &$content, $projectID) {
    $project = $handler->getOneProject($projectID);
    if($project === false) {
        $content .= "Projekt existiert nicht.";
    } else {

        $content .= $project['course']. " - " .$project['participants']. " - <strong>"
            .$project['name']. "</strong><br/>";

        $content .= '<div contenteditable="true">' .$project['text']. "</div>";
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

    if(isset($_POST['submit'])) {
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

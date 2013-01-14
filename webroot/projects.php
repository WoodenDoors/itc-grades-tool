<?php
require_once('../system/handlers/projectsHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new projectsHandler();
$login = $handler->checkIfLogin();

//neue Seite
//------------------------------------------------------------------------------------------------------------------
$page = new page();
$content = '';
if (!$login){
    $content .= $page->buildResultMessage("errorMsg", "Sie sind nicht eingeloggt! Bitte einloggen.");
} else{
//------------------------------------------------------------------------------------------------------------------
    $content .= "PROJECTS!";

    // this is just a test so far
    // TODO make functions or something for each case
    switch($_GET['page']) {
        case "view": $content .= "view"; break;
        case "delete": $content .= "delete"; break;
        case "add": $content .= "add"; break;
        default: $content .= "default";
    }

    $projects = $handler->getAllProjects();

    // TODO das soll natürlich später nicht mehr so hässlich mit Tabellen aussehen, das ist nur ein Test

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
                <td><a href="projects.php?page=view&id=' .$project['ID']. '">view</a></td>
            </tr>';
        $prNr++;
    }

    $content .= '</table>';
}
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
?>

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
    $projects = $handler->getAllProjects();


    // TODO das soll natürlich später nicht mehr so hässlich mit Tabellen aussehen, das ist nur ein Test

    $content .= '<table>';
    $content .= '
        <tr>
            <th>Projekt</th>
            <th>Kurs</th>
            <th>Teilnehmer</th>
            <th>Text</th>
            <th>Note</th>
            <th></th>
            <th></th>
        </tr>';

    $prNr=1;
    foreach($projects as $project) {
        $grade = ($project['grade'] == 0.0) ? "nicht bewertet" : $project['grade'];
        $content .= "<tr>
                <td>" .$prNr. "</td>
                <td>" .$project['course'] ."</td>
                <td>" .$project['participants'] ."</td>
                <td>" .$project['text'] ."</td>
                <td>" .$grade .'</td>
                <td><a href="#">view</a></td>
                <td><a href="#">X</a></td>
            </tr>';
        $prNr++;
    }

    $content .= '</table>';
}
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
?>

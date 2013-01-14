<?php
require_once('../system/handlers/projectsHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new projectsHandler();
$login = $handler->checkIfLogin();
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
function view($handler, &$content) {
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
                <td><a href="projects.php?page=edit&id=' .$project['ID']. '">more</a></td>
            </tr>';
        $prNr++;
    }

    $content .= '</table>';
}

function edit() {

}

function add($handler, &$content) {
    $content .= '<form action="{REQUEST_URI}" method="post" enctype="multipart/form-data" accept-charset="UTF-8">';

    $content .= '<fieldset id="addProject">
            <label for="semester">Semester:</label>
            <select name="semester" id="semester">
            </select>
            <label for="course">Fach:</label>
            <select name="course" id="course">
                {ALL_GRADES}
            </select><br/>
            <label for="grade">Note:</label>
            <input name="grade" id="grade"/><br/>
            <button class="button fancyBtn" id="name" name="submit">Absenden</button>
        </fieldset>
    </form>';

}
//------------------------------------------------------------------------------------------------------------------

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
    $subPage = ( !isset($_GET['page']) ) ? "view" : $_GET['page'];
    switch( $subPage ) {
        case "edit":
            $content .= "delete";
            break;
        case "add":
            $content .= "add";
            break;
        case "view":
        default: $content .= "default";
    }

    view($handler, $content);

}
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
?>

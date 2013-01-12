<?php
require_once('../system/handlers/addGradesHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new addGradesHandler();
$login = $handler->checkIfLogin();

// neue Seite
//------------------------------------------------------------------------------------------------------------------
$page = new page();
$login = $handler->checkIfLogin();

//------------------------------------------------------------------------------------------------------------------
$content = '';
if (!$login) {
    $content .= '<span class="msg errorMsg">Sie sind nicht eingeloggt! Bitte einloggen.</span>';

} else {
    $username = $handler->getUsername();
    $vorname = $handler->getVorname();
    $nachname = $handler->getNachname();
    $email = $handler->getEmail();
    $UserID = $handler->getUserID($username);

    // TODO über Template einbinden:
    $content .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">';
    $content .=
         '<fieldset id="hinzufuegen">
            <label for="course">Fach:</label>
            <select name="course" id="course">
                <option value="MCI">MCI</option>
                <option value="Prog1">Programmierung 1</option>
            </select><br/>
            <label for="grade">Note:</label>
            <input name="grade" id="grade" value="1.0"/><br/>
            <button class="button fancyBtn" id="name" name="submit">Absenden</button>
         </fieldset>
    </form>';

    if( isset( $_POST['submit'] ) ) {
        $course = $_POST['course'];
        $course = $handler->getCourseID($course);
        $handler->validateGrades($UserID['ID'],$_POST['grade'], $course['CourseID']);
    }
}
$page->set_body_content($content);
echo $page->get_page();
?>

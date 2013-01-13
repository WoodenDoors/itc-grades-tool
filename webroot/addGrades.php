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

    $semester = $handler->getSemester();

// Submit
//------------------------------------------------------------------------------------------------------------------
    if( isset( $_POST['submit'] ) ) {
        $valid = $handler->validateGrades($_POST['grade'], $_POST['course']);

        if($valid === true) {
            $content .= $page->buildResultMessage(
                "successMsg",
                "Note ".$_POST['grade']." für den Kurs ".$_POST['course']." hinzugefügt."
            );
        } else {
            $content .= $page->buildResultMessage("errorMsg", $valid);
        }
    }
//------------------------------------------------------------------------------------------------------------------
    // TODO Select für Semester, welches bei Änderung des Feldes sofort die Seite neuläd (mit geändertem Paramter)
    // getCourses nimmt als optionalen Parameter das Semester
    $courses = $handler->getCourses();

    $all_grades='';
    foreach($courses as $course) {
        $all_grades .= '<option value="'.$course['abbreviation'].'">'.$course['course'].'</option>
        ';
    }

// Template
//------------------------------------------------------------------------------------------------------------------
    $content .= $page->loadAdditionalTemplate(
        "grades_add",
        [
            "ALL_GRADES" => $all_grades,
            "REQUEST_URI" => $_SERVER['REQUEST_URI']
        ]
    );
}
$page->set_body_content($content);
echo $page->get_page();
?>

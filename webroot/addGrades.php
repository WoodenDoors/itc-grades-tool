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

// Submit
//------------------------------------------------------------------------------------------------------------------
    if( isset( $_POST['submit'] ) ) {
        $course = $_POST['course'];
        $course = $handler->getCourseID($course);
        $handler->validateGrades($UserID['ID'], $_POST['grade'], $course['course_id']);
    }
//------------------------------------------------------------------------------------------------------------------
    // TODO Select für Semester, welches bei Änderung des Feldes sofort die Seite neuläd (mit geändertem Paramter)
    // getCourses nimmt als optionalen Parameter das Semester
    $courses = $handler->getCourses();

    $all_grades='';
    foreach($courses as $course) {
        $all_grades .= '<option value="'.$course['abbreviation'].'">'.$course['course'].'</option>\n';
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

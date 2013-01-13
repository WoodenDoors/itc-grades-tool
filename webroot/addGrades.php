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
    if (isset($_GET["semester"]))
        $semester = $_GET["semester"];
    else
        $semester = $handler->getSemester();

// Submit
//------------------------------------------------------------------------------------------------------------------
    if (isset($_POST['submit'])) {
        $valid = $handler->validateGrades($_POST['grade'], $_POST['course']);

        if ($valid === true) {
            $content .= $page->buildResultMessage(
                "successMsg",
                "Note " . $_POST['grade'] . " für den Kurs " . $_POST['course'] . " hinzugefügt."
            );
        } else {
            $content .= $page->buildResultMessage("errorMsg", $valid);
        }
    }
//------------------------------------------------------------------------------------------------------------------
    // DONE Select für Semester, welches bei Änderung des Feldes sofort die Seite neuläd (mit geändertem Paramter)
    // getCourses nimmt als optionalen Parameter das Semester
    // Alle Semester von 1 - $semester dürfen angezeigt werden
    $semesters = [1, 2, 3, 4, 5];
    $semester_string = "";
    foreach ($semesters as $tmp_semester) {
        $selected = "";
        if($semester == $tmp_semester) $selected = ' selected="selected"';
        $semester_string .= '<option value="' . $tmp_semester . '"'.$selected.'>' . $tmp_semester . '. Semester</option>';
    }

    $courses = $handler->getCourses($semester);
    $all_grades = '';
    foreach ($courses as $course) {
        $all_grades .= '<option value="' . $course['abbreviation'] . '">' . $course['course'] . '</option>
        ';
    }

// Template
//------------------------------------------------------------------------------------------------------------------
    $content .= $page->loadAdditionalTemplate(
        "grades_add",
        [
            "ALL_GRADES" => $all_grades,
            "ALL_SEMESTERS" => $semester_string,
            "REQUEST_URI" => $_SERVER['REQUEST_URI']
        ]
    );
}
$page->set_body_content($content);
echo $page->get_page();
?>

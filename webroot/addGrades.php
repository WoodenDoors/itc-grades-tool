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
    $display_semester = (isset($_GET["semester"]) && ($_GET['semester'] <= $semester))
        ? $_GET["semester"]
        : $semester;

// Submit
//------------------------------------------------------------------------------------------------------------------
    if (isset($_POST['submit'])) {
        $edit = (isset($_POST['edit'])) ? true : false;
        $valid = $handler->validateGrades($_POST['grade'], $_POST['course'], $edit);

        if ($valid === true) {
            $updateText = ($edit) ? "geändert" : "hinzugefügt";
            $content .= $page->buildResultMessage(
                "successMsg",
                "Note " . $_POST['grade'] . " für den Kurs " . $_POST['course'] . " $updateText."
            );
        } else {
            $content .= $page->buildResultMessage("errorMsg", $valid);
        }
    }
//------------------------------------------------------------------------------------------------------------------
    // DONE Select für Semester, welches bei Änderung des Feldes sofort die Seite neuläd (mit geändertem Paramter)
    // getCourses nimmt als optionalen Parameter das Semester
    // Alle Semester von 1 - $semester dürfen angezeigt werden

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

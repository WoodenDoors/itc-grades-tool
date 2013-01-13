<?php
require_once('../system/handlers/viewGradesHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new viewGradesHandler();
$login = $handler->checkIfLogin();

//neue Seite
//------------------------------------------------------------------------------------------------------------------
$page = new page();
$content = '';
if (!$login){
    $content .= $page->buildResultMessage("errorMsg", "Sie sind nicht eingeloggt! Bitte einloggen.");
} else{
//------------------------------------------------------------------------------------------------------------------
    if(!$handler->hasGrades()){
        $content .= $page->buildResultMessage("errorMsg", "Keine Noten eingetragen!");
    } else {
        $results = $handler->getGrades();

        $content .= '<table name="view">';
        $content .= '<tr><th>Kürzel</th><th>Note</th></tr>';

        $semester=0;
        foreach($results as $result) {
            if( $result['semester'] > $semester ) {
                $semester++;
                $content .= "<tr><td>$semester. Semester</td></tr>";
            }
            $content .= "<tr><td>".$result['abbreviation']."<td><td>".$result['grade']."</td></tr>";
        }
        $content .= '</table>';
    }

//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
}
?>

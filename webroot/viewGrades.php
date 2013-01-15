<?php
require_once('../system/handlers/viewGradesHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new viewGradesHandler();
$login = $handler->checkIfLogin();

//neue Seite
//------------------------------------------------------------------------------------------------------------------
$page = new page();
$page->addcss('jquery.jqplot.min.css');
$page->addjs('js/jquery.jqplot.min.js');
$page->addjs('js/jqplot.categoryAxisRenderer.min.js');
$page->addjs('js/jqplot.categoryAxisRenderer.min.js');
$page->addjs('js/jqplot.barRenderer.min.js');
$page->addjs('js/graphs.js');

$content = '';
if (!$login){
    $content .= $page->buildResultMessage("errorMsg", "Sie sind nicht eingeloggt! Bitte einloggen.");
} else{
//------------------------------------------------------------------------------------------------------------------
    if(!$handler->hasGrades()){
        $content .= $page->buildResultMessage("errorMsg", "Keine Noten eingetragen!");
    } else {
        $results = $handler->getGrades();

        $content .= '<div id="gradesGraph"></div>';

        $content .= '<table name="view">';
        $content .= '<tr><th>Kürzel</th><th>Note</th></tr>';

        $semester=0;
        $gradeAverageSem=0;
        $gradeAverageAll=0;
        $gradeNoSem=0;
        $gradeNoAll=0;
        $firstLoop=true;
        foreach($results as $result) {
            if( $result['semester'] > $semester ) {
                //Für das erste Semester wird der Teil übersprungen
                if($firstLoop){
                    $firstLoop=false;
                }
                //Am Ende jedes Semesters wird der Durschnitt ausgegeben und zurückgesetzt
                else{
                    $gradeAverageSem = $gradeAverageSem/$gradeNoSem;
                    $content .= "<tr><td>Avg:</td><td>".round($gradeAverageSem,2)."</td></tr>";
                    $gradeAverageSem =0;
                    $gradeNoSem=0;
                }
                $semester++;
                $content .= "<tr><td>$semester. Semester</td></tr>";
            }
            $gradeAverageSem += $result['grade'];
            $gradeAverageAll += $result['grade'];
            $content .= "<tr><td>".$result['abbreviation']."<td><td>".$result['grade']."</td></tr>";
            $gradeNoSem++;
            $gradeNoAll++;
        }
        //Für das letzte Semester wird nach der Schleife der Schnitt berechnet
        $gradeAverageSem = $gradeAverageSem/$gradeNoSem;
        $gradeAverageAll = $gradeAverageAll/$gradeNoAll;
        $content .= "<tr><td>Avg:</td><td>".round($gradeAverageSem,2)."</td></tr>";
        $content .= "<tr><td>Gesamt :</td><td>".round($gradeAverageAll,2)."</td></tr>";
        $content .= '</table>';

        $content .= '<button id="generateGraph">Generate</button>';
    }

//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
}
?>

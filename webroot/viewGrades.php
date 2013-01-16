<?php
require_once('../system/handlers/viewGradesHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new viewGradesHandler();
$login = $handler->checkIfLogin();


//neue Seite
//------------------------------------------------------------------------------------------------------------------
$page = new page();
$page->addcss('css/jquery.jqplot.min.css');
$page->addjs('js/jquery.jqplot.min.js');
$page->addjs('js/jqplot.categoryAxisRenderer.min.js');
$page->addjs('js/jqplot.donutRenderer.min.js');
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

        $content .= '<table id="gradesView">';
        $content .= '<tr><th>Kürzel</th><th>Note</th><th>Credits</th></tr>';

        $semester = 0;
        $gradeAverageSem = 0;
        $gradeAverageAll = 0;
        $gradeNoSem = 0;
        $gradeNoAll = 0;
        $sumCredits = 0;
        $sumCreditsSem = 0;
        $firstLoop = true;
        foreach($results as $result) {
            if( $result['semester'] > $semester ) {
                //Für das erste Semester wird der Teil übersprungen
                if($firstLoop){
                    $firstLoop=false;
                }
                //Am Ende jedes Semesters wird der Durschnitt ausgegeben und zurückgesetzt
                else{
                    $gradeAverageSem = round($gradeAverageSem/$gradeNoSem, 2);
                    $content .= '<tr class="gradesAverage"><td>Durchschnitt:</td><td>'.$gradeAverageSem.'</td><td>'.$sumCreditsSem.'</tr>';
                    $gradeAverageSem = 0;
                    $sumCreditsSem = 0;
                    $gradeNoSem = 0;
                }
                $semester = $result['semester'];
                $content .= '<tr class="gradesSemesterName"><td>'.$semester.'. Semester</td><td></td></tr>';
            }
            $gradeAverageSem += $result['grade'];
            $gradeAverageAll += $result['grade'];
            $sumCreditsSem += $result['credits'];
            $sumCreditsAll += $result['credits'];
            $content .= '<tr><td title="'.$result['course'].'">'.$result['abbreviation'].'</td>';
            $content .= '<td class="userGrade">'.$result['grade'].'</td><td>'.$result['credits'].'</td></tr>';
            $gradeNoSem++;
            $gradeNoAll++;
        }
        //Für das letzte Semester wird nach der Schleife der Schnitt berechnet
        $gradeAverageSem = round($gradeAverageSem/$gradeNoSem, 2);
        $gradeAverageAll = round($gradeAverageAll/$gradeNoAll, 2);
        $content .= '<tr class="gradesTotalAverage"><td>Durchschnitt:</td><td>' .$gradeAverageSem. '</td><td>'.$sumCreditsSem.'</td></tr>';
        $content .= '<tr class="gradesTotal"><td>Gesamt :</td><td>' .$gradeAverageAll. '</td><td>'.$sumCreditsAll.'</tr>';
        $content .= '</table>';
    }

//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
}
?>

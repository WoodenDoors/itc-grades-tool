<?php
require_once('../system/handlers/viewGradesHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new viewGradesHandler();
$page = new page(true, $handler);
$login = $handler->getLogin();

//neue Seite
//------------------------------------------------------------------------------------------------------------------
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

        $semester = 0;
        $gradeAverageSem = 0;
        $gradeAverageAll = 0;
        $gradeNoSem = 0;
        $gradeNoAll = 0;
        $sumCreditsAll = 0;
        $sumCreditsSem = 0;
        $firstLoop = true;
        $gradesData = "";
        foreach($results as $result) {
            $courseCredits = ($result['grade'] > 4) ? 0 : $result['credits'];

            if( $result['semester'] > $semester ) {
                //Für das erste Semester wird der Teil übersprungen
                if($firstLoop){
                    $firstLoop=false;
                }
                //Am Ende jedes Semesters wird der Durschnitt ausgegeben und zurückgesetzt
                else{

                    $gradeAverageSem = round($gradeAverageSem/$gradeNoSem, 2);
                    $gradesData .= $page->loadAdditionalTemplate(
                        "grades_view_Average", [
                            "gradeAverageSem" => $gradeAverageSem,
                            "sumCreditsSem" => $sumCreditsSem
                        ]
                    );
                    $gradeAverageSem = 0;
                    $sumCreditsSem = 0;
                    $gradeNoSem = 0;
                }
                $semester = $result['semester'];
                $gradesData .= $page->loadAdditionalTemplate(
                    "grades_view_subTitle", [
                        "SUBTITLE" => $semester.'. Semester'
                    ]
                );
            }
            $gradeAverageSem += $result['grade'];
            $gradeAverageAll += $result['grade'];
            $sumCreditsSem += $courseCredits;
            $sumCreditsAll += $courseCredits;
            $gradesData .= $page->loadAdditionalTemplate(
                "grades_view_singleGrade", [
                    "COURSE" => $result['course'],
                    "ABBREVIATION" => $result['abbreviation'],
                    "GRADE" => $result['grade'],
                    "CREDITS" => $courseCredits
                ]
            );
            $gradeNoSem++;
            $gradeNoAll++;
        }
        //Für das letzte Semester wird nach der Schleife der Schnitt berechnet
        $gradeAverageSem = round($gradeAverageSem/$gradeNoSem, 2);
        $gradeAverageAll = round($gradeAverageAll/$gradeNoAll, 2);
        $gradesData .= $page->loadAdditionalTemplate(
            "grades_view_TotalAverage", [
                "gradeAverageSem" => $gradeAverageSem,
                "sumCreditsSem" => $sumCreditsSem,
                "gradeAverageAll" => $gradeAverageAll,
                "sumCreditsAll" => $sumCreditsAll
            ]
        );
        $content .= $page->loadAdditionalTemplate(
            "grades_view", [
                "TBODY" => $gradesData
        ]);

    }

//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
}
?>

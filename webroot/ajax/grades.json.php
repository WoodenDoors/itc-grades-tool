<?php
require_once('../../system/handlers/viewGradesHandler.class.php');
$handler = new viewGradesHandler();

if (!$handler->checkIfLogin()) { die("Kein Zugriff."); }

function grades_output($handler) {
    $set = $handler->getGrades();
    foreach($set as $item) {
        $result[] = [
            "Abbr" => $item['abbreviation'],
             "Grade" => $item['grade']
        ];
    }
    return $result;
}

function credits_output($handler) {
    $set = $handler->getGrades();
    foreach($set as $item) {
        if($item['grade'] <= 4) {
            $result[] = [
                "Abbr" => $item['abbreviation'],
                "Credits" => $item['credits']
            ];
        }
    }
    if( !isset($result) ) {
        return 'Keine Daten';
    }
    return $result;
}


$type = (isset($_GET['type'])) ? $_GET['type'] : "grades";

switch($type) {
    case "credits":
        $result = credits_output($handler); break;
    default:
        $result = grades_output($handler);
}
echo json_encode($result);
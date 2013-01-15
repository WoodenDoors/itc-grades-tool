<?php
require_once('../../system/handlers/viewGradesHandler.class.php');
$handler = new viewGradesHandler();

if (!$handler->checkIfLogin()) { die("Kein Zugriff."); }

$set = $handler->getGrades();
foreach($set as $item) {
    $result[] = [
        "Abbr" => $item['abbreviation'],
         "Grade" => $item['grade']
    ];
}
echo json_encode($result);
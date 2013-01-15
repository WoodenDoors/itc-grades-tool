<?php
require_once('../../system/handlers/viewGradesHandler.class.php');
$handler = new viewGradesHandler();

if (!$handler->checkIfLogin()) { die("Kein Zugriff."); }

$set = $handler->getGrades();
foreach($set as $item) {
    $result[] = [
        $item['abbreviation'] => $item['grade']
    ];
}
echo json_encode($result);
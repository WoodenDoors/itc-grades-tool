<?php
require_once('../../system/handlers/viewGradesHandler.class.php');
$handler = new viewGradesHandler();

if (!$handler->checkIfLogin()) { die("Kein Zugriff."); }
echo json_encode($handler->getGrades());
<?php
require_once '../system/template/page.class.php';
ini_set("display_errors", 1);
ini_set("html_errors", 1);

//$handler = new pageHandler();
$page = new page();

$content = $page->loadAdditionalTemplate(
    "hero_unit", [
        "HEADING" => "ITC Grades Tool",
        "DESCRIPTION" => "Das perfekte Tool für die Notenübersicht am ITC. Hier kann der aktuelle Fortschritt nachvollzogen werden indem man einfach seine Noten eingibt und zu jeder Zeit einen Überblick über seinen aktuellen Stand hat.",
        "LINK" => "about.php"
]);

$page->set_body_content($content);
echo $page->get_page();
?>

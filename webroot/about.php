<?php
require_once('../system/handlers/pageHandler.class.php');
require_once '../system/template/page.class.php';
$page = new page();

$content = "";
$content .='
    <h1>Über das Projekt</h1>
    <p>Ein Projekt der Erstsemester-Studenten des IT-Center Dortmund im Ramen der Veranstaltung GDI1.</p>
    <p><strong>Team:</strong>
    Sebastian Zier, Marius Rüter, Michael Stein und Mathias Wegmann</p>
    <h2>Credits</h2>
    <p>Folgende externe Projekte wurden zum erstellen dieses Projektes benutzt:</p>
    <pre>
Stringparser:
Christian Seiler <spam@christian-seiler.de>

Template:
Patrick Canterino <patrick@patshaping.de>

bootmetro:
Marcello Palmitessa
    </pre>
';

// Ausgabe
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
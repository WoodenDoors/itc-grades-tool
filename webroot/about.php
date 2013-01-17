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
<a href="http://www.christian-seiler.de/projekte/php/bbcode/doc/phpdoc/earthli/stringparser/_stringparser.class.php.html">Stringparser:
Christian Seiler</a>

<a href="http://patshaping.de/projekte/template-class/index.htm">Template:
Patrick Canterino</a>

<a href="http://aozora.github.com/bootmetro/index.html">bootmetro:
Marcello Palmitessa</a>

<a href="http://jquery.com/">jQuery</a>

<a href="http://www.jqplot.com">jqPlot</a>
    </pre>
';

// Ausgabe
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
<?php
require_once('../system/handlers/pageHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new pageHandler();
$page = new page();
$login = $handler->checkIfLogin();

$content = "";
if (!$login) {
    $content .= $page->buildResultMessage("errorMsg", "Sie sind nicht eingeloggt! Bitte einloggen.");
} else {
    $content .='<a href="addGrades.php">Noten hinzufügen</a>';

    $content .='
        <table class="gradesView">
            <tr>
                <th>Fach</th>
                <th>Note</th>
            </tr>
            <tr>
                <td>MCI</td>
                <td>3.8</td>
            </tr>
            <tr>
                <td>P1</td>
                <td>1.2</td>
            </tr>
            <tr>
                <td>GDI2</td>
                <td>2.8</td>
            </tr>
        </table>
    ';
}

// Ausgabe
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
?>
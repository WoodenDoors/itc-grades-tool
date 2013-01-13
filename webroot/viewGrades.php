<?php
require_once('../system/handlers/viewGradesHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new viewGradesHandler();
$login = $handler->checkIfLogin();

//neue Seite
$page = new page();
$content = '';
if (!$login){
    $content .= '<span class="msg errorMsg">Sie sind nicht eingeloggt! Bitte einloggen.</span>';
} else{
    $username = $handler->getUsername();
    $vorname = $handler->getVorname();
    $nachname = $handler->getNachname();
    $email = $handler->getEmail();

    if(!$handler->hasGrades($username)){
        $content .= '<span class="msg errorMsg">Keine Noten eingetragen!</span>';
    } else {

        //getGrades
        $results = $handler->getGrades($username);

        $content .= '<table name="view">';
        $content .= '<tr><th>Kürzel</th><th>Note</th></tr>';

        foreach($results as $result) {
            $content .= "<tr><td>".$result['abbreviation']."<td><td>".$result['grade']."</td></tr>";
        }
        $content .= '</table>';
    }
$page->set_body_content($content);
echo $page->get_page();
}
?>

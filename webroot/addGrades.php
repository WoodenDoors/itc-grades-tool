<?php
require_once('../system/handlers/addGradesHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new addGradesHandler();
$login = $handler->checkIfLogin();

// neue Seite
//------------------------------------------------------------------------------------------------------------------
$page = new page();
$login = $handler->checkIfLogin();

if (!$login) {
    $content = '<span class="msg errorMsg">Sie sind nicht eingeloggt! Bitte einloggen.</span>';
} else {

    // TODO über Template einbinden:
    $username = $handler->getUsername();
    $vorname = $handler->getVorname();
    $nachname = $handler->getNachname();
    $email = $handler->getEmail();
    
    $content.=
    '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        <input type="select">
            <option name="MCI">MCI</option>
            <option name="Programmierung1">Programmierung1</option>
        </input>
    </form>';
}
$page->set_body_content($content);
echo $page->get_page();
?>

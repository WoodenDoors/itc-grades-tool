<?php
require_once('../system/handlers/loginHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new loginHandler();
$handler->checkIfLogin();

// Formular übermittelt
//------------------------------------------------------------------------------------------------------------------
$result_msg=NULL;
if(isset( $_POST['submit'] )) {
    $result_msg = $handler->validateInput( $_POST['login'], $_POST['pass'] );
}

// neue Seite
//------------------------------------------------------------------------------------------------------------------
$page = new page();
$login = $handler->checkIfLogin(); // Schon eingelogt?

// Diverse Prüfungen
//------------------------------------------------------------------------------------------------------------------
$content = ''; // Damit wir was dranhängen können
// Schon vorher eingeloggt:
if ($login) {
    $content .= $page->buildResultMessage("successMsg", "Schon eingeloggt!");
}

// Gerade (durch Form-Übermittlung) eingeloggt:
if($result_msg===false) {
    $content .= $page->buildResultMessage("successMsg", "Erfolgreich eingeloggt!", true, "index.php"); // mit redirect

// Nicht eingeloggt
} else {
    // Bei Fehler nach Übermittlung
    if(!empty($result_msg)) {
        $content .= $page->buildResultMessage("errorMsg", $result_msg);
    }

// Das Formular
//------------------------------------------------------------------------------------------------------------------
    $content .= $page->loadAdditionalTemplate(
        "user_login", [ "REQUEST_URI" => $_SERVER['REQUEST_URI'] ]
    );
}

// Ausgabe
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
?>
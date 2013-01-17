<?php
require_once('../system/handlers/registerHandler.class.php');
require_once('../system/template/page.class.php');
$handler = new registerHandler();
$page = new page(true, $handler);
$login = $handler->getLogin();

// Abgeschicktes Formular validieren
//------------------------------------------------------------------------------------------------------------------
$result_msg=NULL;
if(isset( $_POST['submit'] )) {
    $result_msg = $handler->validateInput(
        $_POST['username'],
        $_POST['vorname'],
        $_POST['nachname'],
        $_POST['email'],
        $_POST['pass']
    );
}

// Diverse Prüfungen
//------------------------------------------------------------------------------------------------------------------
$content = ""; // Damit wir was dranhängen können
// Schon vorher eingeloggt:
if ($login) {
    $content .= $page->buildResultMessage("successMsg", "Schon eingeloggt!");
}

// Gerade (durch Form-Übermittlung) eingeloggt:
if($result_msg===false) {
    $content .= $page->buildResultMessage("successMsg", "Erfolgreich registriert!", true, "login.php"); // mit redirect

// Nicht übermittelt oder fehlerhafte Übermittlung
} else {
    // Bei Fehler nach Übermittlung
    if(!empty($result_msg)) {
        $content .= $page->buildResultMessage("errorMsg", $result_msg);
    }

// Das Formular
//------------------------------------------------------------------------------------------------------------------
    $content .= $page->loadAdditionalTemplate(
        "user_register", [ "REQUEST_URI" => $_SERVER['REQUEST_URI'] ]
    );
}

// Ausgabe
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
?>
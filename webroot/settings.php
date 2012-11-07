<?php
require_once('../system/handlers/settingsHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new settingsHandler();
$login = $handler->checkIfLogin();

$result_msg=NULL;
if(isset( $_POST['nameSettingsSubmit'] )) {
    $result_msg = $handler->validateNameSettings(
        $_POST['username'],
        $_POST['vorname'],
        $_POST['nachname'],
        $_POST['email']
    );
}

if(isset( $_POST['pwSettingsSubmit'] )) {
    $result_msg = $handler->validatePwSettings(
        $_POST['passAlt'],
        $_POST['passNeu'],
        $_POST['passNeu2']
    );
}

// new page
$page = new page();
$page->set_userControl_content($handler->checkIfLogin(), $handler->getUsername());

// build page content
$content = '';
if (!$login) {
    $content = '<span class="msg errorMsg">Sie sind nicht eingeloggt! Bitte einloggen.</span>';
} else {

    if(!empty($result_msg)) {
        $content .= '<span class="msg errorMsg">' .$result_msg. '</span>';
    }

    if($result_msg===false) {
        $content .= '<span class="msg successMsg">Einstellungen erfolgreich geändert!</span>';
    }
    // Das Formular
    $content .= $page->loadAdditionalTemplate(
        "settings",
        [
            "SETTINGS_USERNAME" => $handler->getUsername(),
            "SETTINGS_VORNAME" => $handler->getVorname(),
            "SETTINGS_NACHNAME" => $handler->getNachname(),
            "SETTINGS_EMAIL" => $handler->getEmail(),
            "REQUEST_URI" => $_SERVER['REQUEST_URI']
        ]
    );
}

// set content and output
$page->set_body_content($content);
echo $page->get_page();
?>
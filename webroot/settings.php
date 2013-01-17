<?php
require_once('../system/handlers/settingsHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new settingsHandler();
$page = new page(true, $handler);
$login = $handler->getLogin();

// Form 1 (IDs) übermittelt
//------------------------------------------------------------------------------------------------------------------
$result_msg = NULL;
if (isset($_POST['nameSettingsSubmit'])) {
    $result_msg = $handler->validateNameSettings(
        $_POST['username'],
        $_POST['vorname'],
        $_POST['nachname'],
        $_POST['email'],
        $_POST['semester']
    );
}

// Form 2 (PW) übermittelt
//------------------------------------------------------------------------------------------------------------------
if (isset($_POST['pwSettingsSubmit'])) {
    $result_msg = $handler->validatePwSettings(
        $_POST['passAlt'],
        $_POST['passNeu'],
        $_POST['passNeu2']
    );
}

// Seiten-Inhalt zusammen bauen
//------------------------------------------------------------------------------------------------------------------
$content = "";
if (!$login) {
    $content .= $page->buildResultMessage("errorMsg", "Sie sind nicht eingeloggt! Bitte einloggen.");
} else {

    // Fehler
    if (!empty($result_msg)) {
        $content .= $page->buildResultMessage("errorMsg", $result_msg);
    }

    // Erfolg
    if ($result_msg === false) {
        $content .= $page->buildResultMessage("successMsg", "Einstellungen erfolgreich geändert!");
    }

    $tplMain = false;
    $tplPassword = false;
    if (isset($_GET['mode'])) {
        switch ($_GET['mode']) {
            case "main":
                $tplMain = true;
                break;
            case "password":
                $tplPassword = true;
                break;
        }
    } else {
        $tplMain = true;
        $tplPassword = true;
    }

// Das Formular
//------------------------------------------------------------------------------------------------------------------
    if ($tplMain) {
        $content .= $page->loadAdditionalTemplate(
            "user_settings",
            [
                "SETTINGS_USERNAME" => $handler->getUsername(),
                "SETTINGS_VORNAME" => $handler->getVorname(),
                "SETTINGS_NACHNAME" => $handler->getNachname(),
                "SETTINGS_EMAIL" => $handler->getEmail(),
                "SETTINGS_SEMESTER" => $handler->getSemester(),
                "REQUEST_URI" => $_SERVER['REQUEST_URI']
            ]
        );
    }

    if ($tplPassword) {
        $content .= $page->loadAdditionalTemplate(
            "user_settings_password",
            [
                "REQUEST_URI" => $_SERVER['REQUEST_URI']
            ]
        );
    }
}

// Ausgabe
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
?>
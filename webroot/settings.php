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

    // TODO über Template einbinden:
    $username = $handler->getUsername();
    $vorname = $handler->getVorname();
    $nachname = $handler->getNachname();
    $email = $handler->getEmail();

// Das Formular
//------------------------------------------------------------------------------------------------------------------
    $content .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">';
    $content .= '
        <fieldset id="nameSettings">
            <legend>Einstellungen</legend>
            <label for="username">Nutzername:</label>
            <input name="username" id="username" type="text" size="30" maxlength="30" required autofocus />

            <label for="vorname">Vorname:</label>
            <input name="vorname" id="vorname" type="text" size="30" maxlength="30" />

            <label for="nachname">Nachname:</label>
            <input name="nachname" id="nachname" type="text" size="30" maxlength="30" />

            <label for="email">Email Adresse:</label>
            <input name="email" id="email" type="email" size="30" maxlength="40" required />

            <button name="nameSettingsSubmit" class="button fancyBtn" id="nameSettingsSubmit">Abschicken</button>
        </fieldset>
        </form>';

    $content .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">';
    $content .= '
        <fieldset id="pwSettings">
                <legend>Passwort ändern</legend>
                <label for="passAlt">Altes Password:</label>
                <input name="passAlt" id="passAlt" type="password" size="30" maxlength="50" required />

                <label for="passNeu">Neues Password:</label>
                <input name="passNeu" id="passNeu" type="password" size="30" maxlength="50" required />

                <label for="passNeu2">Neues Password nochmal:</label>
                <input name="passNeu2" id="passNeu2" type="password" size="30" maxlength="50" required />

                <button name="pwSettingsSubmit" class="button fancyBtn" id="pwSettingsSubmit">Abschicken</button>
            </fieldset>
        </form>';
}

$page = new page();
$page->set_userControl_content($handler->checkIfLogin(), $handler->getUsername());
$page->set_body_content($content);
echo $page->get_page();
?>
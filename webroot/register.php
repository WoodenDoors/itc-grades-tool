<?php
require_once('../system/handlers/registerHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new registerHandler();
$handler->checkIfLogin();

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

// neue Seite
//------------------------------------------------------------------------------------------------------------------
$page = new page();
$login = $handler->checkIfLogin();
$page->set_userControl_content($login, $handler->getUsername());

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
    $content .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post"
                    enctype="multipart/form-data" accept-charset="UTF-8">';
    $content .= '
        <fieldset id="registration">
        <legend>Registrierung</legend>
            <label for="username">Nutzername:</label> 
            <input name="username" id="username" type="text" size="30" maxlength="30" required autofocus />

            <label for="vorname">Vorname:</label> 
            <input name="vorname" id="vorname" type="text" size="30" maxlength="30" />

            <label for="nachname">Nachname:</label> 
            <input name="nachname" id="nachname" type="text" size="30" maxlength="30" />

            <label for="email">Email Adresse:</label> 
            <input name="email" id="email" type="email" size="30" maxlength="40" required />

            <label for="pass">Password:</label> 
            <input name="pass" id="pass" type="password" size="30" maxlength="50" required />

            <span class="hint">Alle mit * markierten Felder sind Pflichtangaben</span>
            <div style="clear:both"></div>
            <button name="submit" class="button fancyBtn" id="submit">Abschicken</button>
        </fieldset>
    </form>';
}

// Ausgabe
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
?>
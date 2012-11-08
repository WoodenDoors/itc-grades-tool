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
    $content .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post"
                    enctype="multipart/form-data" accept-charset="UTF-8">';
    $content .= '
        <fieldset>
            <legend>Login</legend>
            <label for="login">Nutzername oder Email:</label>
            <input name="login"id="login" type="text" size="30" maxlength="30" required autofocus />

            <label for="pass">Passwort:</label>
            <input name="pass" id="pass" type="password" size="30" maxlength="50" required />

            <button name="submit" class="button fancyBtn" id="submit">Login</button>
        </fieldset>
    </form>';
}

// Ausgabe
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
?>
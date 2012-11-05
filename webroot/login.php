<?php
require_once('../system/handlers/loginHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new loginHandler();
$login = $handler->checkIfLogin(); // Schon eingelogt?

// Formular übermittelt
$result_msg=NULL;
if(isset( $_POST['submit'] )) {
    $result_msg = $handler->validateInput( $_POST['login'], $_POST['pass'] );
}

$content = ''; // Damit wir was dranhängen können
// Schon vorher eingeloggt:
if ($login) {
    $content = '<span class="msg successMsg">Schon eingeloggt!</span>';
}

// Gerade (durch Form-Übermittlung) eingeloggt:
if($result_msg===false) {
    $content .= '<span class="msg successMsg">Erfolgreich eingeloggt!</span>';

    // TODO Auf jeden Fall irgendwie auslagern!
    $content .= '<script type="text/javascript">setTimeout(function () { window.location.href = "index.php"; }, 2000);</script>';

// Nicht eingeloggt
} else {
    // Bei Fehler nach Übermittlung
    if(!empty($result_msg)) {
        $content .= '<span class="msg errorMsg">' .$result_msg. '</span>';
    }

    // Das Formular
    $content .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post" enctype="multipart/form-data" accept-charset="UTF-8">';
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

$page = new page();
$page->set_userControl_content($handler->checkIfLogin(), $handler->getUsername());
$page->set_body_content($content);
echo $page->get_page();
?>
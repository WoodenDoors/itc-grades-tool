<?php
require_once('../system/handlers/pageHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new pageHandler();
$page = new page();
$login = $handler->checkIfLogin();

$content = "";
if (!$login) {
    $content .= $page->buildResultMessage("errorMsg", "Sie sind nicht eingeloggt! Bitte einloggen.");
} else {

    $content .= '<form action="'.$_SERVER['REQUEST_URI'].'" method="post"
                    enctype="multipart/form-data" accept-charset="UTF-8">';
    $content .= '
        <fieldset id="registration">
        <legend>Note hinzufügen:</legend>
            <label for="subject">Fach:</label>
            <select name="subject" id="subject" autofocus>
                <option value="fg" selected="selected">Formale Grundlagen</option>
                <option value="mci">MCI</option>
                <option value="p1">Programmierung 1</option>
            </select>

            <label for="grade">Note:</label>
            <input name="grade" id="grade" type="text" size="10" maxlength="3" />

            <span class="hint">Noten werden im Format "1.0" geschrieben.</span>
            <div style="clear:both"></div>
            <button name="submit" class="button fancyBtn" id="submit">Hinzufügen</button>
        </fieldset>
    </form>';
}

// Ausgabe
//------------------------------------------------------------------------------------------------------------------
$page->set_body_content($content);
echo $page->get_page();
?>
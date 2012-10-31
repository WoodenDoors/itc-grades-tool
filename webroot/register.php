<?php
require_once('../system/handlers/registerHandler.class.php');

if(isset($_POST['submit2'])) {
    $handler = new registerHandler(
            $_POST['username'], 
            $_POST['vorname'], 
            $_POST['nachname'], 
            $_POST['email'], 
            $_POST['pass'] 
    );

    $result_msg = $handler->validateInput();
    $handler->submitInput();
}
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        .msg { display:block; padding: 10px; margin: 10px 0 10px 0; background-color: tomato; }
        label, input, button { display: block; }
        input { margin-bottom: 10px; }
        span.hint { font-size: 0.8em; }
    </style>
</head>
<body>
    <?php if(!empty($result_msg)) { echo '<span class="msg">' .$result_msg. '</span>'; }?>
    
    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        <fieldset>
        <legend>Registrierung</legend>
            <label for="username">Nutzername:</label> 
            <input name="username" id="username" type="text" size="30" maxlength="30" required autofocus />

            <label for="vorname">Vorname:</label> 
            <input name="vorname" id="vorname" type="text" size="30" maxlength="30" required />

            <label for="nachname">Nachname:</label> 
            <input name="nachname" id="nachname" type="text" size="30" maxlength="30" required />

            <label for="email">Email Adresse:</label> 
            <input name="email" id="email" type="email" size="30" maxlength="40" required />

            <label for="pass">Password:</label> 
            <input name="pass" id="pass" type="password" size="30" maxlength="50" required />

            <span class="hint">Alle Felder sind Pflichtangaben</span>
            <!-- erster Button für deaktivierte Validation - später rausnehmen -->
            <input type="submit" formnovalidate name="submit2" id="submit2" value="Test" />
            <button name="submit" id="submit">Abschicken</button>
        </fieldset>
    </form>
</body>
</html>
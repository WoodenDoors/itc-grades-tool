<?php
require_once('../system/handlers/loginHandler.class.php');
$handler = new loginHandler();
$login = $handler->checkIfLogin(); // Schon eingelogt?

// Formular übermittelt
$result_msg=NULL;
if(isset($_POST['submit2'])) {
    $result_msg = $handler->validateInput( $_POST['login'], $_POST['pass'] );
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        .msg { display:block; padding: 10px; margin: 10px 0 10px 0; border-radius: 5px;  }
        .errorMsg { background-color: tomato; }
        .successMsg { background-color: #adff2f; }
    </style>
</head>
<body>
    <?php
    if(!empty($result_msg)) { echo '<span class="msg errorMsg">' .$result_msg. '</span>'; }
    if($result_msg===false) { echo '<span class="msg successMsg">Erfolgreich eingeloggt!</span>';}
    ?>
    
    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
        <fieldset>
            <legend>Login</legend>
            <label for="login">Nutzername oder Email:</label>
            <input name="login"id="login" type="text" size="30" maxlength="30" required autofocus />

            <label for="pass">Passwort:</label>
            <input name="pass" id="pass" type="password" size="30" maxlength="50" required />

            <!-- erster Button für deaktivierte Validation - später rausnehmen -->
            <input type="submit" formnovalidate name="submit2" id="submit2" value="Test" />
            <button name="submit" id="submit">Login</button>
        </fieldset>
    </form>
</body>
</html>
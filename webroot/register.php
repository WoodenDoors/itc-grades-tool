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
        label { display: block; }
    </style>
</head>
<body>
    <?php if(!empty($result_msg)) { echo '<span class="msg">' .$result_msg. '</span>'; }?>
    
    <form action="register.php" method="post">
        <label for="username">Username:</label> 
        <input name="username" id="username" type="text" required autofocus />

        <label for="vorname">Vorname:</label> 
        <input name="vorname" id="vorname" type="text" required />

        <label for="nachname">Nachname:</label> 
        <input name="nachname" id="nachname" type="text" required />

        <label for="email">Email Adresse:</label> 
        <input name="email" id="email" type="email" required />

        <label for="pass">Password:</label> 
        <input name="pass" id="pass" type="password" required />

        <!-- erster Button für deaktivierte Validation - später rausnehmen -->
        <input type="submit" formnovalidate name="submit2" id="submit2" value="Test" />
        <button name="submit" id="submit">Abschicken</button>
    </form>
</body>
</html>
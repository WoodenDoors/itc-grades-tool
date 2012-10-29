<?php
require_once('registerHandler.class.php');


if(isset($_POST['submit2'])) {
    $handler = new registerHandler(
            $_POST['username'], 
            $_POST['vorname'], 
            $_POST['nachname'], 
            $_POST['email'], 
            $_POST['pass'] );

    echo $handler->testInput();
}
?>
<!DOCTYPE html>
<html><head>
<style>
    label { display: block; }
</style>
</head>
<body>
    
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
    
    <input type="submit" formnovalidate name="submit2" id="submit2" value="Test" />
    <button name="submit" id="submit">Abschicken</button>
</form>
    
</body>
</html>
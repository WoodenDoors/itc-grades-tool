<?php
require_once('../system/handlers/viewGradesHandler.class.php');
require_once '../system/template/page.class.php';
$handler = new viewGradesHandler();
$login = $handler->checkIfLogin();

if (!$login){
    $content = '<span class="msg errorMsg">Sie sind nicht eingeloggt! Bitte einloggen.</span>';
}else{
    $username = $handler->getUsername();
    $vorname = $handler->getVorname();
    $nachname = $handler->getNachname();
    $email = $handler->getEmail();
    
    if(!$handler->hasGrades($username)){
      $content = '<span class="msg errorMsg">Keine Noten eingetragen!</span>';  
    }
    else{
        $content.='<table name="view">
               <tr><th>Kürzel</th><th>Note</th></tr>';
        //getGrades
        $handler->getGrades($username,$content);
        $content.='</table>';
    }
}
?>

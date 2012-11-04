<?php
/* Cookie löschen und auf Index umleiten */

setcookie("username", false);
setcookie("pass", false);
header("Location: index.php");
?>
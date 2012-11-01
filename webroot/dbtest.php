<?php

require_once('../system/db/database.class.php');

$config = new dbconfig();
$db = new database($config);

$db->openConnection();

// Verbindung testen
echo "Verbindung besteht" . ( $db->testServerConnection() ? "." : " NICHT!<br/>");

// Test Query
$sql = $db->selectRows("*", "itc-grades-tool_users", "username", "Mathes");

// Tests
echo "<br/>Es gibt " . ($db->hasRows($sql) ? "" : "keine") ." Reihen.";
echo "<br/>Es gibt " . $db->countRows($sql) ." Reihe(n).";

// Userdata ausgeben
$result = $db->fetchAssoc($sql);
echo "<pre>";
print_r($result);
echo "</pre>";
?>
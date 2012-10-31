<?php

require_once('../system/db/database.class.php');

$config = new dbconfig();
$db = new database($config);

$db->openConnection();

// Verbindung testen
echo "Verbindung besteht" . ( $db->testServerConnection() ? "." : " NICHT!<br/>");

// Test Query
$sql = $db->query("SELECT * FROM `itc-grades-tool_users`");

// Tests
echo "<br/>Es gibt " . ($db->hasRows($sql) ? "" : "keine") ." Reihen.";
echo "<br/>Es gibt " . $db->countRows($sql) ." Reihe(n).";

// Userdata ausgeben
$result = $db->fetchAssoc($sql);
echo "<pre>";
print_r($result);
echo "</pre>";

// Verbindung schließen
$db->closeConnection();
?>
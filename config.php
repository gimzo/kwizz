<?php
/****************************
 *      Konfiguracija
 *
 */

// MySQL podaci:
$db_server='localhost';
$db_baza='kwizz';
$db_username='kwizz';
$db_password='password1234';

/****************
Kraj konfiguracije
Dragons below this line:
**********************/

// Ovdje dodajemo globalne funkcije kad nam budu trebale.

// Database connect
function db_connect() {
	global $db_server, $db_baza, $db_username, $db_password, $mysqli;
	$mysqli=new mysqli("$db_server", "$db_username", "$db_password", "$db_baza");

	if (mysqli_connect_errno()) {
		die("Failed to connect to MySQL: " .mysqli_connect_errno());
	}
}

// Database disconnect
function db_disconnect() {
	global $mysqli;
	$mysqli->close();
}
?>

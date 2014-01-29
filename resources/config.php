<?php
/****************************
 *      Konfiguracija
 *
 */

// MySQL podaci:
define('DB_SERVER', 'localhost');
define('DB_NAME', 'kwizz');
define('DB_USERNAME', 'kwizz');
define('DB_PASSWORD', 'password1234');

/****************
Kraj konfiguracije
Dragons below this line:
**********************/

// Ovdje dodajemo globalne funkcije kad nam budu trebale.

//postaviti stvar na UTF-8
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');
if (!headers_sent()) {
	header('Content-Type: text/html; charset=utf-8');
}

// Database connect
function db_connect() {
	global $mysqli;
	$mysqli=mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	mysqli_set_charset($mysqli,'utf8');

	if (mysqli_connect_errno()) {
		die("Failed to connect to MySQL: " .mysqli_connect_errno());
	}
}

// Database disconnect
function db_disconnect() {
	global $mysqli;
	mysqli_close($mysqli);
}
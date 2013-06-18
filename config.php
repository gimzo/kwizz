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

//postaviti stvar na UTF-8
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');

// Database connect
function db_connect() {
	global $db_server, $db_baza, $db_username, $db_password, $mysqli;
	$mysqli=mysqli_connect("$db_server", "$db_username", "$db_password", "$db_baza");
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

// Form report
function form_report() {
	// Za gresku postaviti POST: Report Failure
	// Za uspjesno obavljeno postaviti POST: Report Success
	if (isset($_POST['ReportFailure'])) {
		echo "<div id='formReport' class='redReport'>";
			echo "<div id='reportImg'><img src='./images/warning.png' alt='Warning' width='32' height='32'></div>";
			foreach ($_POST['ReportFailure'] as $report):
				echo "<div id='reportContent' class='displayTable'><div class='vertMiddle'><p>$report</p></div></div>";
			endforeach;
		echo "</div>";
	} elseif (isset($_POST['ReportSuccess'])) {
		echo "<div id='formReport' class='greenReport'>";
			echo "<div id='reportImg'><img src='./images/success.png' alt='Success' width='32' height='32'></div>";
			foreach ($_POST['ReportSuccess'] as $report):
				echo "<div id='reportContent' class='displayTable'><div class='vertMiddle'><p>$report</p></div></div>";
			endforeach;
		echo "</div>";
	}
}
?>

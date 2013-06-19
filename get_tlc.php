<?php
	session_start();
	include_once 'config.php';
	if (!isset($_SESSION['user'])) {
		die();
	}
	db_connect();
	$result=mysqli_query($mysqli, "SELECT id_kategorija, naziv_kategorija FROM kategorija WHERE nadkategorija IS NULL;");
	db_disconnect();
	$kategorije=Array();
	while ($data=mysqli_fetch_array($result)) {
		$kategorije[$data['id_kategorija']]=$data['naziv_kategorija'];
	}
	echo json_encode($kategorije);
?>

<?php
	session_start();
	require_once '../config.php';

	db_connect();
	$stmt = $mysqli->prepare("INSERT INTO chat (id_posiljatelj, id_primatelj, tekst_poruka) VALUES (?, ?, ?)");
	$stmt->bind_param('iis', $_SESSION['id'], $_GET['user'], $_GET['text']);
	$stmt->execute();
	$res = $stmt->get_result();
	$stmt->close();
	db_disconnect();
?>
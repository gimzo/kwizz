<?php
	session_start();
	require_once '../config.php';

	db_connect();
	$stmt = $mysqli->prepare("SELECT * FROM (SELECT tekst_poruka, id_poruka, id_posiljatelj FROM chat WHERE (id_primatelj=? AND id_posiljatelj=?) OR (id_primatelj=? AND id_posiljatelj=?) ORDER BY id_poruka DESC LIMIT 5) AS msg ORDER BY msg.id_poruka ASC");
	$stmt->bind_param('iiii', $_GET['user'], $_SESSION['id'], $_SESSION['id'], $_GET['user']);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	$messages = array();
	$i = 0;

	$stmt = $mysqli->prepare("SELECT nadimak_korisnik FROM korisnik WHERE id_korisnik=?");

	while ($conv = $result->fetch_array()) {

		$stmt->bind_param('i', $conv['id_posiljatelj']);
		$stmt->execute();
		$result2 = $stmt->get_result();
		$sender = $result2->fetch_array();

		$messages[$i]['time'] = $conv['id_poruka'];
		$messages[$i]['text'] = $conv['tekst_poruka'];
		$messages[$i]['sender'] = $conv['id_posiljatelj'];
		$messages[$i]['nick'] = $sender['nadimak_korisnik'];
		$i++;
	}

	$stmt->close();
	db_disconnect();

	echo json_encode($messages);
?>
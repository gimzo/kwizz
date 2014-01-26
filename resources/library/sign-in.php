<?php
	session_start();
	include_once '../config.php';

	// $successful:
	// 0 - form not filled
	// 1 - sign in successful
	// 2 - incorrect nickname and/or password

	$successful = 0;

	if (!empty($_POST['nickname']) && !empty($_POST['password'])) {

		$nickname = $_POST['nickname'];
		$password = $_POST['password'];
		
		db_connect();

		$stmt = $mysqli->prepare("SELECT id_korisnik FROM korisnik WHERE nadimak_korisnik = ? AND password_korisnik = md5(?)");
		$stmt->bind_param("ss", $nickname, $password);
		$stmt->execute();
		$res = $stmt->get_result();
		$stmt->close();

		if (mysqli_num_rows($res) == 1) {
			$row = $res->fetch_array();
			$_SESSION['user']=$nickname;
			$_SESSION['id'] = $row['id_korisnik'];
			$successful = 1;
		} else {
			$successful = 2;
		}
		
		db_disconnect();

	}

	echo json_encode($successful);
?>
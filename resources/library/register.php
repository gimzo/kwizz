<?php
	include_once '../config.php';

	// $successful:
	// 0 - form not filled
	// 1 - registration successful
	// 2 - nickname already in use

	$successful = 0;

	if (!empty($_POST['nickname']) && !empty($_POST['password']) && !empty($_POST['country'])) {

		$nickname = $_POST['nickname'];
		$password = $_POST['password'];
		$country = $_POST['country'];
		
		db_connect();

		$stmt = $mysqli->prepare("SELECT nadimak_korisnik FROM korisnik WHERE nadimak_korisnik=?");
		$stmt->bind_param("s", $nickname);
		$stmt->execute();
		$res = $stmt->get_result();
		$stmt->close();

		if (mysqli_num_rows($res) == 0) {
			$stmt = $mysqli->prepare("INSERT INTO korisnik (nadimak_korisnik, password_korisnik, drzava_korisnik) VALUES (?, md5(?), ?)");
			$stmt->bind_param("sss", $nickname, $password, $country);
			$stmt->execute();
			$stmt->close();
			$successful = 1;
		} else {
			$successful = 2;
		}
		
		db_disconnect();

	}

	echo json_encode($successful);
?>
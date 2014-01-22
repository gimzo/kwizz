<?php
	session_start();

	include_once 'config.php';

	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}

	$user = $_SESSION['user'];
	$id = $_SESSION['id'];
	db_connect();								
	$result=mysqli_query($mysqli, "SELECT * FROM korisnik WHERE id_korisnik='$id';");
	$data=mysqli_fetch_array($result);
	echo "<form method='POST' action='editProfile.php'>";
	echo "Nickname: &nbsp;<input type='text' value='".$data['nadimak_korisnik']."' name='nadimak'><br>";
	echo "Full name: &nbsp;<input type='text' value='".$data['ime']."' name='ime'><br>";
	echo "Location: &nbsp;<input type='text' value='".$data['drzava_korisnik']."' name='lokacija'><br>";
	echo "About me: &nbsp;<input type='text' value='".$data['about']."' name='about'><br>";
	echo "<input type='submit' value='End editing' name='uredi'>";
	echo "</form>";

	if(isset($_POST['uredi'])) {
		$nadimak = $_POST['nadimak'];
		$ime = $_POST['ime'];
		$lokacija = $_POST['lokacija'];
		$about = $_POST['about'];

		$result=mysqli_query($mysqli, "UPDATE korisnik SET nadimak_korisnik='$nadimak', ime='$ime', drzava_korisnik='$lokacija', about='$about' WHERE id_korisnik='$id';");
		//echo "UPDATE korisnik SET nadimak_korisnik='$nadimak', ime='$ime', drzava_korisnik='$lokacija', about='$about' WHERE id_korisnik='$id';";
		header('Location: profile.php');
	}
	db_disconnect();
?>
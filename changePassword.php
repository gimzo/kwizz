<?php
	session_start();

	include_once 'resources/config.php';

	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}

	if (!empty($_POST['old']) && !empty($_POST['new']) && !empty($_POST['retype'])) {
		$old=$_POST['old'];
		$new=$_POST['new'];
		$retype=$_POST['retype'];

		db_connect();

		$result=mysqli_query($mysqli, "SELECT password_korisnik FROM korisnik WHERE id_korisnik='$_SESSION[id]'");
		$data=mysqli_fetch_array($result);

		if ($data[0]==md5($old) && $new==$retype) {
			$result=mysqli_query($mysqli, "UPDATE korisnik SET password_korisnik=md5('$new') WHERE id_korisnik='$_SESSION[id]'");
			header('Location: profile.php');
		}

		db_disconnect();
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Change password</title>
</head>
<body>
	<form action='changePassword.php' method='POST'>
		Current: <input type="password" name="old"><br>
		New: <input type="password" name="new"><br>
		Retype new: <input type="password" name="retype"><br>
		<input type="submit" value="Save changes" name="name"><br>
		<a href="profile.php">Cancel</a>
	</form>
</body>
</html>
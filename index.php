<?php 
	session_start();

	include_once 'config.php';
	
	if ($_SERVER['REQUEST_METHOD']==='POST') {
		// Ako sesija nije aktivna login
		if (!isset($_SESSION['user'])) {

			$nickname=$_POST['nickname'];
			$password=$_POST['password'];

			db_connect();

			$nickname=mysqli_real_escape_string($mysqli, $nickname);
			$password=mysqli_real_escape_string($mysqli, $password);

			$result=mysqli_query($mysqli, "SELECT id_korisnik FROM korisnik WHERE nadimak_korisnik = '$nickname' AND password_korisnik = md5('$password');");
			if (mysqli_num_rows($result)==1) {
				$_SESSION['user']="$nickname";
				header('Location: index.php');
			} else {
				echo "Wrong username or password!";
			}

		 	db_disconnect();

		} else {
			// Inace logout
			unset($_SESSION['user']);
			header('Location: index.php');
		}
	}
?>

<!DOCTYPE html> 
<html>
<head>
	<title>Homepage</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div id="wrapper">
		<?php include_once 'bar.php'; ?>
	</div>
</body>
</html>
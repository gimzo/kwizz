<?php 
	session_start();
	if ($_SERVER['REQUEST_METHOD']==='POST') {
		// Ako je sesija aktivna izvrsava se logout
		if (isset($_SESSION['user'])) {
			unset($_SESSION['user']);
		} else {
			// Inace login
			include_once 'config.php';

			// TO-DO: Refresh stranice kod POST-a
			// TO-DO: Sigurnost logina

			$nickname=$_POST['nickname'];
			$password=$_POST['password'];

			db_connect();

			$result=mysqli_query($mysqli, "SELECT id_korisnik FROM korisnik WHERE nadimak_korisnik = '$nickname' AND password_korisnik = md5('$password');");
			if (mysqli_num_rows($result)==1) {
				$_SESSION['user']="$nickname";
			} else {
				// Brise varijable u sesiji
				unset($_SESSION['user']);
				echo "Wrong password!";
			}

			db_disconnect();
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
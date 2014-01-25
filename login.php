<?php
	session_start();

	include_once 'resources/config.php';

	if ($_SERVER['REQUEST_METHOD']==='POST') {
		$nickname=$_POST['nickname'];
		$password=$_POST['password'];

		if (!empty($nickname) && !empty($password)) {
			db_connect();

			$nickname=mysqli_real_escape_string($mysqli, $nickname);
			$password=mysqli_real_escape_string($mysqli, $password);
	
			$result=mysqli_query($mysqli, "SELECT id_korisnik FROM korisnik WHERE nadimak_korisnik = '$nickname' AND password_korisnik = md5('$password');");
			$row=mysqli_fetch_array($result);
			if (mysqli_num_rows($result)==1) {
				$_SESSION['user']="$nickname";
				$_SESSION['id'] = $row['id_korisnik'];
			} else {
				$_POST['ReportFailure']=array("Wrong username or password!");
			}
					
			db_disconnect();
		} else {
			$_POST['ReportFailure']=array("Please fill all fields to continue registration.");
		}
	}

	if (isset($_SESSION['user'])) {
		header('Location: index.php');
	}
?>

<!DOCTYPE html> 
<html>
	<head>
		<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div class="container">
			<form class="col-lg-offset-4 col-lg-4" action="login.php" method="post" accept-charset="UTF-8">
				<fieldset>
					<legend>Login</legend>
					<div class="form-group">
						<label for="nickname">Nickname</label>
						<input type="text" class="form-control" name="nickname" placeholder="Enter nickname" maxlength="20">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" placeholder="Enter password" maxlength="45">
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
					<a href="index.php" class="btn btn-default">Cancel</a>
				</fieldset>
			</form>
		</div>
	</body>
</html>
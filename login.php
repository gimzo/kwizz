<?php
	session_start();

	include_once 'config.php';

	if ($_SERVER['REQUEST_METHOD']==='POST') {
		$nickname=$_POST['nickname'];
		$password=$_POST['password'];

		if (!empty($nickname) && !empty($password)) {
			db_connect();

			$nickname=mysqli_real_escape_string($mysqli, $nickname);
			$password=mysqli_real_escape_string($mysqli, $password);
	
			$result=mysqli_query($mysqli, "SELECT id_korisnik FROM korisnik WHERE nadimak_korisnik = '$nickname' AND password_korisnik = md5('$password');");
			if (mysqli_num_rows($result)==1) {
				$_SESSION['user']="$nickname";
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
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script language="javascript" type="text/javascript">
	function go_back() {
    window.location.href = "index.php";
	}
	</script>
</head>
<body>
	<!-- Login forma -->
	<div id="form">
		<div id="formLogo"></div>
		<div id="formContent">
			<form action="login.php" method="post" accept-charset="UTF-8">
			<fieldset >
				<p>
					<label for"nickname">Nickname:</label><br>
					<input type="text" name="nickname" id="nickname" maxlength="20" />
				</p>
				<p>
					<label for="password">Password:</label><br>
					<input type="password" name="password" id="password" maxlength="45" />
				</p>
		 		<button type="button" class="floatL" onclick="go_back()">Go back</button> 
				<input type="submit" name="Submit" value="Login" class="floatR" />
			</fieldset>
			</form>
		</div>
	</div>
	<?php form_report() ?>
</body>
</html>
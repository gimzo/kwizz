<?php
	session_start();
	include_once 'resources/config.php';
	header("Content-type: text/html; charset=utf-8");
	if (!isset($_SESSION['user'])) {
		header("Location: index.php");
		die();
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
		<title>Kwizz | Rankings</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<!-- Header -->
		<?php include_once 'resources/templates/header.php'; ?>
		<!-- Menu -->
		<?php include_once 'resources/templates/menu.php'; ?>
		<div class="section purple">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<p class="lead text-center font-lg">Edit your password:</p>
					</div>
				</div>
			</div>
		</div>
		<div class="section red">
			<div class="container">
				<div class="row">
					<div class="col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
						<form role="form" action='changePassword.php' method='POST'>
							<div class="form-group">
								<label>Current password</label>
								<input type="password" class="form-control" name="old" placeholder="Enter current password">
							</div>
							<div class="form-group">
								<label>New password</label>
								<input type="password" class="form-control" name="new" placeholder="Enter new password">
							</div>
							<div class="form-group">
								<label>Retype new password</label>
								<input type="password" class="form-control" name="retype" placeholder="Retype new password">
							</div>
							<p class="text-center"><button type="submit" name="name" class="btn btn-default">Submit</button></p>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- Footer -->
		<?php include_once 'resources/templates/footer.php'; ?>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>
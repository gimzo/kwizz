<?php
	session_start();
	include_once 'resources/config.php';
	header("Content-type: text/html; charset=utf-8");
	if (!isset($_SESSION['user'])) {
		header("Location: index.php");
		die();
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
						<p class="lead text-center font-lg">Edit your profile:</p>
					</div>
				</div>
			</div>
		</div>
		<div class="section red">
			<div class="container">
				<div class="row">
					<div class="col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
						<?php
							$user = $_SESSION['user'];
							$id = $_SESSION['id'];
							db_connect();								
							$result=mysqli_query($mysqli, "SELECT * FROM korisnik WHERE id_korisnik='$id';");
							$data=mysqli_fetch_array($result);
							echo '<form role="form" method="POST" action="editProfile.php">';
							echo '<div class="form-group">
								    <label>Nickname</label>
								    <input type="text" class="form-control" name="nadimak" value="'.$data['nadimak_korisnik'].'" placeholder="Enter nickname">
								  </div>';
							echo '<div class="form-group">
								    <label>Full Name</label>
								    <input type="text" class="form-control" name="ime" value="'.$data['ime'].'" placeholder="Enter full name">
								  </div>';
							echo '<div class="form-group">
								    <label>Location</label>
								    <input type="text" class="form-control" name="lokacija" value="'.$data['drzava_korisnik'].'" placeholder="Enter location">
								  </div>';
							echo '<div class="form-group">
								    <label>About me</label>
								    <input type="text" class="form-control" name="about" value="'.$data['about'].'" placeholder="Enter about me">
								  </div>';
							echo '<p class="text-center"><button type="submit" name="uredi" class="btn btn-default">Submit</button></p>';
							echo "</form>";

							if(isset($_POST['uredi'])) {
								$nadimak = $_POST['nadimak'];
								$ime = $_POST['ime'];
								$lokacija = $_POST['lokacija'];
								$about = $_POST['about'];

								$result=mysqli_query($mysqli, "UPDATE korisnik SET nadimak_korisnik='$nadimak', ime='$ime', drzava_korisnik='$lokacija', about='$about' WHERE id_korisnik='$id';");
								//echo "UPDATE korisnik SET nadimak_korisnik='$nadimak', ime='$ime', drzava_korisnik='$lokacija', about='$about' WHERE id_korisnik='$id';";
								header('Location: editProfile.php');
							}
							db_disconnect();
						?>
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
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
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
						<p class="lead text-center font-lg">See how well you stack up:</p>
					</div>
				</div>
			</div>
		</div>
		<div class="section red">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<?php
							db_connect();

							$rezultat = mysqli_query($mysqli,"SELECT * FROM rezultat NATURAL JOIN korisnik WHERE id_mode=0 ORDER BY rezultat DESC;");

							if (mysqli_num_rows($rezultat) > 0) {
								echo "<table class='table text-center'><thead><tr><th class='text-center'># Rank</th><th class='text-center'>Player</th><th class='text-center'>Full name</th><th class='text-center'>Score</th><th class='text-center'>Country</th></tr></thead>";
								$rank=1;
								echo '<tbody>';
								while ($data = mysqli_fetch_array($rezultat)) {
									if ($data['id_korisnik'] == $_SESSION['id']) {
										echo '<tr style="background-color: rgb(207, 109, 90);"><td>'.$rank.'</td><td>'.$data['nadimak_korisnik'].'</td><td>'.$data['ime'].'</td><td>'.$data['rezultat'].'</td><td>'.strtoupper($data['drzava_korisnik']).'</td></tr>';
									} else {
										echo '<tr><td>'.$rank.'</td><td>'.$data['nadimak_korisnik'].'</td><td>'.$data['ime'].'</td><td>'.$data['rezultat'].'</td><td>'.strtoupper($data['drzava_korisnik']).'</td></tr>';
									}
									$rank++;
								}
								echo "</tbody></table>";
							} else {
								echo "<p class='lead text-center font-lg'>We do not have any scores yet!</p>";
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
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
		<title>Scoreboard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row"><img src="./images/scoreboard.png" class="img-responsive img-center" alt="Scoreboard"></div>
			<div class="hr"></div>
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Kwizz</a>
				</div>
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						<li><a href="index.php">Homepage</a></li>
						<li class="active"><a href="scoreboard.php">Scoreboard</a></li>
					</ul>
					<?php include_once 'loginstatus.php' ?>
				</div>
			</nav>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="panel-title text-center">Scoreboard</h4>
						</div>
						<div class="panel-body">
							<span id="loadingDiv">
								<?php
								db_connect();

								$rezultat=mysqli_query($mysqli,"SELECT * FROM rezultat NATURAL JOIN korisnik WHERE id_mode=0 ORDER BY rezultat DESC;");

								if ($rezultat->num_rows > 0){
								echo "<table class='table table-striped text-center'><tr><th class='text-center'>Rank</th><th class='text-center'>Player</th><th class='text-center'>Score</th></tr>";
								$rank=1;
								while ($data=mysqli_fetch_array($rezultat))
								{
									echo "<tr><td>$rank.</td><td>$data[nadimak_korisnik]</td><td>$data[rezultat]</td></tr>";
									$rank++;
								}
								echo "</table>";
								}
								else
									echo "<p class='text-center'>We do not have any scores yet!</p>";
								db_disconnect();
								?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<div class="footer"><p>&copy; 2013</p></div>
		</div>
	</body>
</html>

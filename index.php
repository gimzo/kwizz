<?php 
	session_start();
	header("Content-type: text/html; charset=utf-8");
?>

<!DOCTYPE html> 
<html>
	<head>
		<title>Kwizz | Homepage</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/game.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row"><img src="./images/logo.png" class="img-responsive img-center" alt="Logo"></div>
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
						<li class="active"><a href="index.php">Homepage</a></li>
						<li><a href="scoreboard.php">Scoreboard</a></li>
					</ul>
					<?php include_once 'loginstatus.php' ?>
				</div>
			</nav>
			<div class="row">
				<div class="col-sm-4 col-lg-3">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h4 class="panel-title text-center">Stats</h4>
						</div>
						<div class="panel-body">
							<p>Total: <span id="total"></span></p>
							<p class="text-success">Current Score: <span id="trenscore"></span></p>
						</div>
					</div>
				</div>
				<div class="col-sm-8 col-lg-9">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="panel-title text-center">Game</h4>
						</div>
						<div class="panel-body">
							<span id="loadingDiv">
								<?php 
								if (isset($_SESSION['user'])) include("game.php");
								if (!isset($_SESSION['user'])) echo "<p class='text-center'>Welcome to Kwizz! Please Log In or Sign Up to proceed.</p>";
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

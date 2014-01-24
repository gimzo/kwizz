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
		<link rel="stylesheet" type="text/css" href="css/style-landing.css">
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/game.js"></script>
	</head>
	<body>
		<?php include_once 'resources/templates/header.php'; ?>
		<?php include_once 'resources/templates/menu.php'; ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-lg-3">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h4 class="panel-title text-center">Stats</h4>
						</div>
						<div class="panel-body">
							<p>Total: <span id="total"></span></p>
							<h4 class="text-success">Current Score: <span id="trenscore"></span></h4>
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
		</div>
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<p class="lead text-center">Created and maintained by:</p>
					</div>
				</div><br>
				<div class="row">
					<div class="col-sm-4">
						<div class="user">
							<a href="https://github.com/swimR">
								<img src="images/iva.jpg" alt="" class="img-circle img-responsive center-block">
							</a>
						</div>
						<p class="text-center">Iva Petrović</p>
					</div>
					<div class="col-sm-4">
						<div class="user">
							<a href="https://github.com/gimzo">
								<img src="images/david.jpg" alt="" class="img-circle img-responsive center-block">
							</a>
						</div>
						<p class="text-center">David Dubrović</p>
					</div>
					<div class="col-sm-4">
						<div class="user">
							<a href="https://github.com/bcr3ative">
								<img src="images/paolo.jpg" alt="" class="img-circle img-responsive center-block">
							</a>
						</div>
						<p class="text-center">Paolo Perković</p>
					</div>
				</div><br><br>
				<p class="text-center">Kwizz &copy; 2014 | <a href="#">Support</a> &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a> &middot; <a href="#">Blog</a> &middot; <a href="#">About Us</a></p>
			</div>
		</footer>
	</body>
</html>

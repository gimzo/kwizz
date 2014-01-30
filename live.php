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
		<title>Kwizz | LivePlay</title>
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
		<!-- Status section -->
		<div class="section purple">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-8 col-md-offset-2"><p class="lead text-center font-lg">Click on Join Game to enter lobby!</p></div>
				</div>
			</div>
		</div>
		<!-- Game section -->
		<div class="section red">
			<div class="container">
				<div class="row">
					<div class="col-sm-offset-1 col-sm-10 col-md-offset-3 col-md-6">
						<button id="menu_btn" type="button" class="btn btn-default" onclick="location.reload();">
							<span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;Back to lobby
						</button>
						<span id="timer" class="pull-right"></span>
						<hr>
						<p class="lead text-center">LivePlay</p>
						<p class="lead text-center" id="broj_pitanja"></p>
						
						<hr>

						<!-- Sucelje -->
						<div id="startgame" class="gamescreen text-center">
							<div class="hr"></div>
							<div id="kat">
							</div>
							<div class="hr"></div>
							<div>
							</div>
							<div class="hr"></div>
							<div id="buttonmsg">
								<br><br><button id="join" class="btn btn-success" onclick="Lobby()">Join Game</button>
							</div>
						</div>
						<div id="rezultat"></div>
						<!-- Prikaz pitanja -->
						<div id="pitanje" class="well well-sm text-center"></div>
						<!-- Odgovori a,b,c,d -->
						<div id="odgovorabcd" class="odgovor"></div>
						<!-- Unos odgovora -->
						<div id="odgovortext" class="odgovor input-group">
							<input type="text" id="txtOdgovor" class="form-control" onkeyup="CheckTekstOdgovora()">
							<span class="input-group-btn">
								<button class="btn btn-default" type="button" id="neznam" onclick="CheckTekstOdgovora(true)">I don't know!</button>
							</span>
						</div>
						<hr>
						<p class="lead text-center" id="drugi_odgovor"></p>
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
		<script src="js/jquery.knob.js"></script>
		<!-- Game javascript file -->
		<script src="js/live.js"></script>

		<!-- Pocetak igre -->
		<script>
			<?php echo "var username='$_SESSION[user]';" ?>
			$(window).load(connect());
		</script>
	</body>
</html>

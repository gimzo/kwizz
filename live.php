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
		<title>Kwizz | Play</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<?php
			// Setting up the category in js
			if (!empty($_GET['category'])) {
				db_connect();
				// Ime kategorije
				$stmt = $mysqli->prepare("SELECT naziv_kategorija FROM kategorija WHERE id_kategorija=?");
				$stmt->bind_param('i', $_GET['category']);
				$stmt->execute();
				$res = $stmt->get_result();
				$row = $res->fetch_array();
				$stmt->close();

				db_disconnect();

				echo '
					<script>
						var categoryId = '.$_GET['category'].';
						var categoryName = "'.$row['naziv_kategorija'].'";
					</script>
				';
			}
		?>
		<!-- Header -->
		<?php include_once 'resources/templates/header.php'; ?>
		<!-- Menu -->
		<?php include_once 'resources/templates/menu.php'; ?>
		<!-- Status section -->
		<div class="section purple">
			<div class="container">
				<div class="row">
					<div id="status-window" class="col-sm-12 col-md-8 col-md-offset-2"></div>
				</div>
			</div>
		</div>
				<!-- Game section -->
		<div id="game-section" class="section red">
			<div class="container">
				<div class="row">
					<div id="game-window" class="col-sm-10 col-sm-offset-1 col col-md-6 col-md-offset-3">
<button id="menu_btn" type="button" class="btn btn-default" onclick="location.reload();">
	<span class="glyphicon glyphicon-align-center"></span> Restart game
</button>
<span id="timer" class="pull-right"></span>
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
		<button id="join" class="btn btn-success" onclick="Lobby()">Join game</button>
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
<div id="drugi_odgovor"></div>
<div id="broj_pitanja"></div>


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
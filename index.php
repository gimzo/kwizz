<?php 
	session_start();
	header("Content-type: text/html; charset=utf-8");
?>

<!DOCTYPE html> 
<html>
<head>
	<title>Kwizz | Homepage</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="js/game.js"></script>
</head>
<body>
	<div id="wrapper">
		<div id="header"><div id="headerLogo"><img src="./images/logo.png" alt="Kwizz logo" width="250" height="102"></div></div>
		<div id="menu">
			<ul>
				<li><a href="scoreboard.php">Scoreboard</a></li>
			</ul>
		</div>
		<?php include_once 'statusbar.php'; ?>
		<div id="content">
			<div id="leftContent">
<<<<<<< HEAD
				<p>Scores</p>
				<div class="hr1"></div>
				<h1>Score: <?php include("myscore.php"); ?> </h1>
=======
				<p>Points</p>
				<div class="hr1"></div>
				<ul>
					<li>Number</li>
				</ul>
>>>>>>> b0c2aff478d89b69284e3d5c1496bb279118b931
			</div>
			<div id="mainContent">
				<p class="horCenter" style="color: #275f88;">Game</p>
				<div class="hr2"></div> 
				<div id="loadingDiv">
					<?php 
					if (isset($_SESSION['user'])) 
						include("game.php"); 
					?>
				</div>
			</div>
			<div class="clearBoth"></div>
		</div>
	</div>
	<?php include_once 'chatbar.php'; ?>
</body>
</html>

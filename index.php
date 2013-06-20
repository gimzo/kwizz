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
	<script src="js/jquery-1.9.1.min.js"></script>
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
				<p>Stats</p>
				<div class="hr1"></div>
				<h1>Total: <span id='total'></span></h1>
				<h2 id='trenscore'></h2>
			</div>
			<div id="mainContent">
				<p class="horCenter" style="color: #275f88;">Game</p>
				<div class="hr2"></div> 
				<div id="loadingDiv">
					<?php 
					if (isset($_SESSION['user'])) include("game.php");
					if (!isset($_SESSION['user'])) {
echo <<<END
					<p style='text-align: center; margin-top: 40px;'>Welcome to Kwizz! Please register/login to proceed.</p>
END;
					}
					?>
				</div>
			</div>
			<div class="clearBoth"></div>
		</div>
	</div>
	<?php include_once 'chatbar.php'; ?>
</body>
</html>

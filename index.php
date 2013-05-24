<?php 
	session_start();
?>

<!DOCTYPE html> 
<html>
<head>
	<title>Homepage</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
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
				<p>Category</p>
				<div class="hr1"></div>
				<ul>
					<li>Category 1</li>
					<li>Catefory 2</li>
					<li>Catefory 3</li>
					<li>Catefory 4</li>
				</ul>
			</div>
			<div id="mainContent">
				<p class="horCenter" style="color: #275f88;">Game</p>
				<div class="hr2"></div> 
				<div id="loadingDiv">
				</div>
			</div>
			<div class="clearBoth"></div>
		</div>
	</div>
</body>
</html>
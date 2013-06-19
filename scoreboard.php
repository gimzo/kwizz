<?php
	session_start();

	include_once 'config.php';

	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
?>

<!DOCTYPE html> 
<html>
<head>
	<title>Scoreboard</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
</head>
<body>
	<div id="wrapper">
		<div id="header"><div id="headerLogo"><img src="./images/scoreboard.png" alt="Scoreboard" width="250" height="102"></div></div>
		<div id="menu">
			<ul>
				<li><a href="index.php">Start playing</a></li>
			</ul>
		</div>
		<?php include_once 'statusbar.php'; ?>
		<div id="content">
			<div id="leftContent">
				<p>Menu</p>
				<div class="hr1"></div>
				<ul>
				</ul>
			</div>
			<div id="mainContent">
				<p class="horCenter" style="color: #275f88;">Scoreboard</p>
				<div class="hr2"></div> 
				<div id="loadingDiv">
					<?php
					db_connect();

					$rezultat=mysqli_query($mysqli,"SELECT * FROM rezultat WHERE id_mode=0 ORDER BY rezultat DESC;");

					if ($rezultat->num_rows > 0)
						echo "We do have scores!";
					else
						echo "We do not have any scores yet!";
					db_disconnect();
					?>
				</div>
			</div>
			<div class="clearBoth"></div>
		</div>
	</div>
 	<?php include_once 'chatbar.php'; ?>
</body>
</html>
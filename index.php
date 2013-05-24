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
		<div id="header"><div id='headerLogo'><img src="./images/logo.png" alt="Kwizz logo" width="250" height="102"></div></div>
		<div id="menu">
			<ul>
				<li><a href='scoreboard.php'>Scoreboard</a></li>
			</ul>
		</div>
		<?php include_once 'statusbar.php'; ?>
	</div>
</body>
</html>
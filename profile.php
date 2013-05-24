<?php
	session_start();

	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
?>

<!DOCTYPE html> 
<html>
<head>
	<title>Profile</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div id="wrapper">
		<div id="header"><div id='headerLogo'><img src="./images/profile.png" alt="Profile" width="250" height="102"></div></div>
		<div id="menu">
		</div>
	</div>
</body>
</html>
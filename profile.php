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
	<title>Profile</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
</head>
<body>
	<div id="wrapper">
		<div id="header"><div id="headerLogo"><img src="./images/profile.png" alt="Profile" width="250" height="102"></div></div>
		<div id="menu">
			<ul>
				<li><a href="index.php">Start playing</a></li>
			</ul>
		</div>
		<div id="content">
			<div id="leftContent">
				<p>Menu</p>
				<div class="hr1"></div>
				<ul>
					<li>Check stats</li>
					<li><a id="AddQuestion">Add question</a></li>
					<li>Change nickname</li>
				</ul>
				<?php
				db_connect();
				$user=$_SESSION['user'];
				$result=mysqli_query($mysqli, "SELECT uloga_korisnik FROM korisnik WHERE nadimak_korisnik = '$user';");
				$rights=mysqli_fetch_array($result);
				if ($rights[0]==="5") {
echo <<<END
				<div class="hr1"></div>
				<p>Admin menu</p>
				<div class="hr1"></div>
				<ul>
					<li>Add category</li>
				</ul>
END;
				}
				db_disconnect();
				?>
			</div>
			<div id="mainContent">
				<p class="horCenter" style="color: #275f88;">Options</p>
				<div class="hr2"></div> 
				<div id="loadingDiv">
				</div>
			</div>
			<div class="clearBoth"></div>
		</div>
	</div>
	<script type="text/javascript"> 
 		$("#AddQuestion").click(function(){
 			$("#loadingDiv").load('add_question.php');
 		});
 	</script>
</body>
</html>
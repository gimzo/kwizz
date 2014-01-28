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
		<title>Profile</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/bootstrap-theme.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="js/jquery-1.10.2.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row"><img src="./images/profile.png" class="img-responsive img-center" alt="Profile"></div>
			<div class="hr"></div>
			<nav class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Kwizz</a>
				</div>
				<div class="collapse navbar-collapse navbar-ex1-collapse">
					<ul class="nav navbar-nav">
						<li><a href="index.php">Homepage</a></li>
						<li><a href="scoreboard.php">Scoreboard</a></li>
					</ul>
					<?php include_once 'loginstatus.php' ?>
				</div>
			</nav>
			<div class="row">
				<div class="col-sm-4 col-lg-3">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h4 class="panel-title text-center">Menu</h4>
						</div>
						<div class="panel-body">
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#" id="AddQuestion">Suggest question</a></li>
								<li><a href="#" id="reset">Reset stats</a></li>
								<?php
									$user=$_SESSION['user'];
									db_connect();
									$query=mysqli_query($mysqli, "SELECT * FROM korisnik WHERE nadimak_korisnik='$user';");
									$result=mysqli_fetch_array($query);

									if($result['uloga_korisnik']==0) {
										echo "<li><a href='admin.php'>Admin page</a></li>";
									}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-sm-8 col-lg-9">
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h4 class="panel-title text-center">Options</h4>
						</div>
						<div class="panel-body">
							<span id="loadingDiv"></span>
							<?php
								db_connect();

								if(!empty($_GET['nickname'])) {
									$nick=$_GET['nickname'];
									$result=mysqli_query($mysqli, "SELECT id_korisnik AS id FROM korisnik WHERE nadimak_korisnik='$nick'");
									$data = mysqli_fetch_array($result);
									$id=$data[0];
								} else{
									$id=$_SESSION['id'];
								}

								if($id!=$_SESSION['id']) {
									
									$result=mysqli_query($mysqli, "SELECT * FROM lista_prijatelja WHERE id_vlasnik='$_SESSION[id]' AND id_prijatelj='$id'");
									$data = mysqli_fetch_array($result);
									if ($data) {
										echo "<a href='profile.php?remove=".$id."&nickname=".$_GET['nickname']."'>Remove from friend list</a><br>";
										//header('Location: friends.php?nickname="David"');
									} else {
										echo "<a href='profile.php?add=".$id."&nickname=".$_GET['nickname']."'>Add to friend list</a><br>";
									}
								}	

								if (!empty($_GET['add']) && !empty($_GET['nickname'])) {
									$result=mysqli_query($mysqli, "INSERT INTO lista_prijatelja VALUES('$_SESSION[id]', '$_GET[add]');");
									header('Location: profile.php?nickname='.$_GET['nickname']);
								}
								if (!empty($_GET['remove']) && !empty($_GET['nickname'])) {
									$result=mysqli_query($mysqli, "DELETE FROM lista_prijatelja WHERE id_vlasnik='$_SESSION[id]' AND id_prijatelj='$_GET[remove]';");
									header('Location: profile.php?nickname='.$_GET['nickname']);
								}							
								
								$result=mysqli_query($mysqli, "SELECT * FROM korisnik WHERE id_korisnik='$id';");
								$data=mysqli_fetch_array($result);
								echo "Nickname: &nbsp;".$data['nadimak_korisnik']."<br>";
								echo "Full name: &nbsp;".$data['ime']."<br>";
								echo "Location: &nbsp;".$data['drzava_korisnik']."<br>";
								echo "About me: &nbsp;".$data['about']."<br>";
								$result = mysqli_query($mysqli, "SELECT COUNT(*) FROM odgovorena_pitanja WHERE id_korisnik='$id';");
								$data = mysqli_fetch_array($result);
								if($data[0]!=0) {
									$result = mysqli_query($mysqli, "SELECT COUNT(*) FROM odgovorena_pitanja WHERE id_korisnik='$id' AND tocno=1;");
									$tocan = mysqli_fetch_array($result);
									$postotak = round(($tocan[0]/$data[0])*100);
									echo "Answered correctly (all categories):&nbsp;".$postotak."%<br>";
								} else {
									echo "You haven't answered any question yet.<br>";
								}						
								$result = mysqli_query($mysqli, "SELECT DISTINCT pitanje_kategorija.id_kategorija AS kategorija, kategorija.naziv_kategorija AS naziv FROM pitanje_kategorija INNER JOIN odgovorena_pitanja ON odgovorena_pitanja.id_pitanje=pitanje_kategorija.id_pitanje INNER JOIN kategorija ON kategorija.id_kategorija=pitanje_kategorija.id_kategorija WHERE id_korisnik='$id';");
								while ($data = mysqli_fetch_array($result)) {
									echo $data['naziv'].":&nbsp;";
									$result1 = mysqli_query($mysqli, "SELECT COUNT(*) FROM odgovorena_pitanja WHERE id_korisnik='$id' AND id_pitanje IN (SELECT id_pitanje FROM pitanje_kategorija WHERE id_kategorija='$data[kategorija]');");
									$ukupno = mysqli_fetch_array($result1);
									$result2 = mysqli_query($mysqli, "SELECT COUNT(*) FROM odgovorena_pitanja WHERE id_korisnik='$id' AND tocno=1 AND id_pitanje IN (SELECT id_pitanje FROM pitanje_kategorija WHERE id_kategorija='$data[kategorija]');");
									$tocno = mysqli_fetch_array($result2);
									$postkat = round(($tocno[0]/$ukupno[0])*100);
									echo $postkat."%<br>";
								}
								if ($id == $_SESSION['id']) {
									echo "<a href='editProfile.php'>Edit profile</a>&nbsp;&nbsp;";
									echo "<a href='changePassword.php'>Change password</a>";
								}
								
								db_disconnect();
							?>
						</div>
					</div>
				</div>
			</div>
			<hr>
			<div class="footer"><p>&copy; 2013</p></div>
		</div>
		<!-- Skripta -->
		<script type="text/javascript"> 
			$("#AddQuestion").click(function(){
				$("#loadingDiv").load('suggest_question.php');
			});
			$("#reset").click(function() {
				var retVal = confirm("Do you really want to reset your score?");
				if( retVal == true ){
					window.location.href = 'dropscore.php';
				}
			});
		</script>
	</body>
</html>

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
		<title>Kwizz | Profile</title>
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
		<div class="section purple">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<?php
							if ((!isset($_GET['nickname'])) || (strtolower($_GET['nickname']) == strtolower($_SESSION['user']))) {
								echo '<p class="lead text-center font-lg">Get to know your stats:</p>';
							} else {
								echo '<p class="lead text-center font-lg">Stats for your friend:</p>';
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="section red">
			<div class="container">
				<div class="row">
					<div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6">
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
									echo '<p class="text-center"><a href="profile.php?remove='.$id.'&nickname='.$_GET['nickname'].'" class="btn btn-default" role="button">Remove from friend list</a></p><hr>';
								} else {
									echo '<p class="text-center"><a href="profile.php?add='.$id.'&nickname='.$_GET['nickname'].'" class="btn btn-default" role="button">Add to friend list</a></p><hr>';
								}
							}

							if ($id == $_SESSION['id']) {
								echo '<p class="text-center"><a href="editProfile.php" class="btn btn-default" role="button">Edit Profile</a>';
								echo '&nbsp;&nbsp;<a href="changePassword.php" class="btn btn-default" role="button">Change password</a></p><hr>';
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
							echo '<p class="lead text-center">Nickname: '.$data['nadimak_korisnik'].'</p>';
							echo '<p class="lead text-center">Full name: '.$data['ime'].'</p>';
							echo '<p class="lead text-center">About: '.$data['about'].'</p>';
							echo '<p class="lead text-center">Country: '.strtoupper($data['drzava_korisnik']).'</p><hr>';
							$result2=mysqli_query($mysqli, "SELECT COUNT(*) AS broj FROM pitanje WHERE id_autor='$id';");
							$data2=mysqli_fetch_array($result2);
							echo '<p class="lead text-center">Number of questions contributed: '.$data2['broj'].'</p>';
							$result = mysqli_query($mysqli, "SELECT COUNT(*) FROM odgovorena_pitanja WHERE id_korisnik='$id';");
							$data = mysqli_fetch_array($result);
							if($data[0]!=0) {
								$result = mysqli_query($mysqli, "SELECT COUNT(*) FROM odgovorena_pitanja WHERE id_korisnik='$id' AND tocno=1;");
								$tocan = mysqli_fetch_array($result);
								$postotak = round(($tocan[0]/$data[0])*100);
								echo '<p class="lead text-center">Answered correctly ( All Categories ):&nbsp;'.$postotak.'%</p>';
							} else if ($data[0]==0) {
								if (!empty($_GET['nickname'])) {
									echo '<p class="lead text-center">No statistics available.</p>';
								} else {
									echo '<p class="lead text-center">You haven\'t answered any question yet.</p>';
								}
							}						
							$result = mysqli_query($mysqli, "SELECT DISTINCT pitanje_kategorija.id_kategorija AS kategorija, kategorija.naziv_kategorija AS naziv FROM pitanje_kategorija INNER JOIN odgovorena_pitanja ON odgovorena_pitanja.id_pitanje=pitanje_kategorija.id_pitanje INNER JOIN kategorija ON kategorija.id_kategorija=pitanje_kategorija.id_kategorija WHERE id_korisnik='$id';");
							while ($data = mysqli_fetch_array($result)) {
								echo '<p class="lead text-center">'.$data['naziv'].': ';
								$result1 = mysqli_query($mysqli, "SELECT COUNT(*) FROM odgovorena_pitanja WHERE id_korisnik='$id' AND id_pitanje IN (SELECT id_pitanje FROM pitanje_kategorija WHERE id_kategorija='$data[kategorija]');");
								$ukupno = mysqli_fetch_array($result1);
								$result2 = mysqli_query($mysqli, "SELECT COUNT(*) FROM odgovorena_pitanja WHERE id_korisnik='$id' AND tocno=1 AND id_pitanje IN (SELECT id_pitanje FROM pitanje_kategorija WHERE id_kategorija='$data[kategorija]');");
								$tocno = mysqli_fetch_array($result2);
								$postkat = round(($tocno[0]/$ukupno[0])*100);
								echo $postkat."%</p>";
							}
							
							db_disconnect();
						?>
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
	</body>
</html>
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
		<title>Kwizz | Friends</title>
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
						<p class="lead text-center font-lg">Search for people you may know:</p>
					</div>
				</div>
			</div>
		</div>
		<div class="section red">
			<div class="container">
				<div class="row">
					<div class="col-sm-4 col-md-4">
						<form role="form" action="friends.php" method="GET">
							<div class="input-group">
								<input type="text" class="form-control" name="nick">
								<span class="input-group-btn">
									<button class="btn btn-default btn-primary" type="submit">Search</button>
								</span>
							</div>
						</form>
						<hr>
						<p class="lead text-center">Friends:<br></p>
						<?php
							db_connect();
							$id=$_SESSION['id'];
							$result=mysqli_query($mysqli, "SELECT lista_prijatelja.id_prijatelj AS id, nadimak_korisnik AS nick FROM lista_prijatelja INNER JOIN korisnik ON korisnik.id_korisnik=lista_prijatelja.id_prijatelj WHERE id_vlasnik='$id';");
							if (mysqli_num_rows($result) > 0) {
								echo '<ul class="nav nav-pills nav-stacked">';
								while ($data=mysqli_fetch_array($result)) {
									echo '<li class="text-center"><a href="profile.php?nickname='.$data['nick'].'">'.$data['nick'].'</a><li>';
								}
								echo '</ul>';
							} else {
								echo '<p class="text-center">You have no friends yet.<p>';
							}
							db_disconnect();
						?>
					</div>
					<div class="col-sm-8 col-md-8">
						<?php
							db_connect();
							if (!empty($_GET['nick'])) {
								$nadimak=$_GET['nick'];
								echo '<p class="lead text-center">Search results for \''.$nadimak.'\':</p><hr>';
								$result=mysqli_query($mysqli, "SELECT nadimak_korisnik FROM korisnik WHERE (nadimak_korisnik like '%$nadimak%' OR ime like '%$nadimak%') AND id_korisnik NOT IN (SELECT id_prijatelj FROM lista_prijatelja WHERE id_vlasnik='$_SESSION[id]')");
								while ($data=mysqli_fetch_array($result)) {
									echo '<p class="lead text-center"><a href="profile.php?nickname='.$data['nadimak_korisnik'].'">'.$data['nadimak_korisnik'].'</a></p>';
								}
							} else {
								echo '<p class="lead text-center">It seems there are no pending queries.</p>';
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
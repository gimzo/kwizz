<?php 
	session_start();
	include_once 'resources/config.php';
	header("Content-type: text/html; charset=utf-8");
?>

<!DOCTYPE html> 
<html>
	<head>
		<title>Kwizz | Homepage</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style-landing.css">
	</head>
	<body>
		<!-- Header -->
		<?php include_once 'resources/templates/header.php'; ?>
		<!-- Menu -->
		<?php
			if (isset($_SESSION['user'])) {
			 	include_once 'resources/templates/menu.php';
			} else {
				echo '
				<div class="section purple">
					<div class="container">
						<div class="jumbotron">
							<h1>Howdy, stranger!</h1><br>
							<p class="text-center">Register now to have fun playing a bunch of different quizzes with a lot of categories to choose from. Sign in if you are already a part of the community.</p><br>
							<p class="text-center"><a href="register.php" class="btn btn-primary blue btn-lg" role="button">Register now!</a>&nbsp; or &nbsp;<a href="login.php" class="btn btn-primary blue btn-lg" role="button">Sign in</a></p>
						</div>
					</div>
				</div>
				';
			}
		?>
		<!-- Content -->
		<div class="section red">
			<div class="container">
				<div class="row">
					<div class="col-sm-12"><h3><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Categories:</h3><br><br></div>
					<div class="row">
						<?php
							db_connect();
							// Nadkategorije
							$stmt = $mysqli->prepare("SELECT id_kategorija, naziv_kategorija FROM kategorija WHERE nadkategorija IS NULL");
							$stmt->execute();
							$res = $stmt->get_result();

							// Podkategorije
							$stmt2 = $mysqli->prepare("SELECT id_kategorija, naziv_kategorija FROM kategorija WHERE nadkategorija=? LIMIT 5");

							while ($category = $res->fetch_array()) {
								echo '
									<div class="col-sm-4 col-md-3">
										<h4 class="text-center">'.$category['naziv_kategorija'].'</h4>
										<div class="list-group">';
											$stmt2->bind_param('i', $category['id_kategorija']);
											$stmt2->execute();
											$res2 = $stmt2->get_result();
											while ($subcategory = $res2->fetch_array()) {
												echo '
													<a href="#" class="list-group-item"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;&nbsp;'.$subcategory['naziv_kategorija'].'</a>
												';
											}
								echo '
										</div>
									</div>
								';
							}
							
							$stmt2->close();
							$stmt->close();
							db_disconnect();
						?>
					</div>
				</div>
			</div>
		</div>
		<!-- Footer -->
		<footer>
			<div class="container">
				<div class="row">
					<p class="lead text-center">Created and maintained by:</p>
				</div><br>
				<div class="row">
					<div class="col-sm-4">
						<div class="user">
							<a href="https://github.com/swimR">
								<img src="images/iva.jpg" alt="" class="img-circle img-responsive center-block">
							</a>
						</div>
						<p class="text-center">Iva Petrović</p>
					</div>
					<div class="col-sm-4">
						<div class="user">
							<a href="https://github.com/gimzo">
								<img src="images/david.jpg" alt="" class="img-circle img-responsive center-block">
							</a>
						</div>
						<p class="text-center">David Dubrović</p>
					</div>
					<div class="col-sm-4">
						<div class="user">
							<a href="https://github.com/bcr3ative">
								<img src="images/paolo.jpg" alt="" class="img-circle img-responsive center-block">
							</a>
						</div>
						<p class="text-center">Paolo Perković</p>
					</div>
				</div><br><br>
				<p class="text-center">Kwizz &copy; 2014 | <a href="#">Support</a> &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a> &middot; <a href="#">Blog</a> &middot; <a href="#">About Us</a></p>
			</div>
		</footer>
	</body>
</html>

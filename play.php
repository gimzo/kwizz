<?php 
	session_start();
	include_once 'resources/config.php';
	header("Content-type: text/html; charset=utf-8");
?>

<!DOCTYPE html> 
<html>
	<head>
		<title>Kwizz | Play</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<?php
			// Setting up the category in js
			if (!empty($_GET['category'])) {
				db_connect();
				// Ime kategorije
				$stmt = $mysqli->prepare("SELECT naziv_kategorija FROM kategorija WHERE id_kategorija=?");
				$stmt->bind_param('i', $_GET['category']);
				$stmt->execute();
				$res = $stmt->get_result();
				$row = $res->fetch_array();
				$stmt->close();

				db_disconnect();

				echo '
					<script>
						var categoryId = '.$_GET['category'].';
						var categoryName = "'.$row['naziv_kategorija'].'";
					</script>
				';
			}
		?>
		<!-- Header -->
		<?php include_once 'resources/templates/header.php'; ?>
		<!-- Menu -->
		<?php include_once 'resources/templates/menu.php'; ?>
		<!-- Status section -->
		<div class="section purple"><div id="status-window" class="container"></div></div>
		<!-- Game section -->
		<div id="game-section" class="section red"><div id="game-window" class="container"></div></div>
		<!-- Categories section -->
		<div id="categories-section" class="section red">
			<?php include_once 'resources/templates/categories.php'; ?>
		</div>
		<!-- Footer -->
		<?php include_once 'resources/templates/footer.php'; ?>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/jquery.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Game javascript file -->
		<script src="js/game2.js"></script>
	</body>
</html>
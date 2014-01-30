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
		<title>Kwizz | Rankings</title>
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
						<p class="lead text-center font-lg">Edit question:</p>
					</div>
				</div>
			</div>
		</div>
		<div class="section red">
			<div class="container">
				<div class="row">
					<div class="col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
						<form role="form" action='save_changes.php' method='GET'>					
						<?php
							$id=$_GET['question'];
							db_connect();
							$query=mysqli_query($mysqli, "SELECT * FROM pitanje WHERE id_pitanje='$id';");
							$result=mysqli_fetch_array($query);
							echo "<input type='hidden' name='id' value='$id'>";
							echo '<div class="form-group">
									<label>Question text</label>
									<input type="text" value="'.$result['tekst_pitanja'].'" class="form-control" name="question">
								</div>';
							echo '<div class="form-group">
									<label>Question points</label>
									<input type="text" value="'.$result['bodovi_pitanja'].'" class="form-control" name="points">
								</div>';
							$row=mysqli_query($mysqli, "SELECT * FROM odgovor WHERE id_pitanje='$id';");
							$i=0;
							echo '<hr>';

							while($answer=mysqli_fetch_array($row)) {
								$i++;
									if($answer['tocan_odgovor']==1) {
										echo '<div class="form-group">
												<label>'.$i.' ) Correct answer</label>
												<input type="text" value="'.$answer['tekst_odgovor'].'" class="form-control" name="tocan">
											</div>';
										echo "<input type='hidden' name='id_tocan' value='".$answer['id_odgovor']."'>";
									} else {
										echo '<div class="form-group">
												<label>'.$i.' ) Answer</label>
												<input type="text" value="'.$answer['tekst_odgovor'].'" class="form-control" name="answer'.$i.'">
											</div>';
										echo "<input type='hidden' name='id_ans".$i."' value='".$answer['id_odgovor']."'>";
									}
							}
							echo '<p class="text-center"><button type="submit" name="potvrdi" class="btn btn-default">Submit</button></p>';
						?>
						</form>
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
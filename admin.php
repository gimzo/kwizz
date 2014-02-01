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
		<title>Kwizz | Admin</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script language="JavaScript">
			function Select() {
				var inputs=document.getElementsByTagName("input");
				for(var i=0; i<inputs.length; i++) {
					if(inputs[i].type=="checkbox") {
						inputs[i].checked=true;
					}
				}
			}
			function Deselect() {
				var inputs=document.getElementsByTagName("input");
				for(var i=0; i<inputs.length; i++) {
					if(inputs[i].type=="checkbox") {
						inputs[i].checked=false;
					}
				}
			}
		</script>
	</head>
	<body>
		<!-- Header -->
		<?php include_once 'resources/templates/header.php'; ?>
		<!-- Menu -->
		<?php include_once 'resources/templates/menu.php'; ?>
		<?php
			if ($_SERVER['REQUEST_METHOD']==='POST') {
				db_connect();
				if (isset($_POST['potvrdi'])) {
					if (!empty($_POST['neodobreno'])) {
	    				foreach($_POST['neodobreno'] as $check) {
	    					$result=mysqli_query($mysqli, "UPDATE pitanje SET odobreno_pitanje=1 WHERE id_pitanje='$check';");
	    				}
	    			}
				} else if (isset($_POST['obrisi'])) {
					if (!empty($_POST['neodobreno'])) {
	    				foreach($_POST['neodobreno'] as $check) {
	           				$result=mysqli_query($mysqli, "DELETE FROM pitanje WHERE id_pitanje='$check';");
	            		}
	            	} else if (!empty($_POST['odobreno'])) {
	            		foreach ($_POST['odobreno'] as $check) {
	            			$result=mysqli_query($mysqli, "DELETE FROM pitanje WHERE id_pitanje='$check';");
	            		}
	            	}
				}	 
				db_disconnect();
			}
		?>
		<div class="section red">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-12">
						<table class="table">
							<thead>
								<tr>
									<th>
										Accepted questions
									</th>
									<th>
										Not ( yet ) accepted
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<?php
											db_connect();
											$result=mysqli_query($mysqli, "SELECT * FROM pitanje WHERE odobreno_pitanje=1;");
											echo "<form method='POST' action='admin.php'>";
											while ($data=mysqli_fetch_array($result)) {
												$id = $data['id_pitanje'];
												echo "<div class='input-group' style='width: 80%;'><input type='text' value='".$data['tekst_pitanja']."' class='form-control'> <span class='input-group-addon'><input type='checkbox' name='odobreno[]' value='".$id."'></span>&nbsp;&nbsp;<a href='edit_question.php?question=".$data['id_pitanje']."' class='btn btn-default' type='button'>Uredi</a></div>";
												echo "Bodovi: " .$data['bodovi_pitanja']."<br>";
												$odgovor=mysqli_query($mysqli, "SELECT * FROM odgovor WHERE id_pitanje='$id';");
												$i=0;
												while ($answer=mysqli_fetch_array($odgovor)) {
													$i++;
													if($answer['tocan_odgovor']==1) {
														echo "Tocan odgovor je: $i) ".$answer['tekst_odgovor'];
													} else {
														echo "$i) ".$answer['tekst_odgovor'];
													}
													echo "&nbsp;";
												}
												echo "<br><br>";
											}
											echo '</form>';
											db_disconnect();
										?>
									</td>
									<td>
										<?php
											db_connect();
											$result=mysqli_query($mysqli, "SELECT * FROM pitanje WHERE odobreno_pitanje=0 limit 20;");
											echo "<form method='POST' action='admin.php'>";
											while ($data=mysqli_fetch_array($result)) {
												$id = $data['id_pitanje'];
												echo "<b>".$data['tekst_pitanja']."</b><input type='checkbox' name='neodobreno[]' value='".$id."'>";
												echo "<a href='edit_question.php?question=".$data['id_pitanje']."'>Uredi</a><br>";
												echo "Bodovi:" .$data['bodovi_pitanja']."<br>";
												$odgovor=mysqli_query($mysqli, "SELECT * FROM odgovor WHERE id_pitanje='$id';");
												$i=0;
												while ($answer=mysqli_fetch_array($odgovor)) {
													$i++;
													if($answer['tocan_odgovor']==1) {
														echo "Tocan odgovor je: $i) ".$answer['tekst_odgovor'];
													} else {
														echo "$i) ".$answer['tekst_odgovor'];
													}
													echo "&nbsp;";
												}
												echo "<br><br>";
											}
											echo '</form>';
											db_disconnect();
										?>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<input type="submit" class="btn btn-default" value="Potvrdi" name="potvrdi">
										<input type="submit" class="btn btn-default" value="Obrisi" name="obrisi">
										<input type="button" class="btn btn-default" onclick="Select();" value="Oznaci sve">
										<input type="button" class="btn btn-default" onclick="Deselect();" value="Odznaci sve">
									</td>
								</tr>
							</tbody>
						</table>
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
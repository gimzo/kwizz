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
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
		<meta charset="UTF-8">
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script language="javascript" type="text/javascript">
		function checkvalue(val) {
			if(val=="1") {
				document.getElementById("potvrdi").style.display = "inline";
				document.getElementById("pitanje").style.display = "inline";
				document.getElementById("a").style.display = "inline";
				document.getElementById("pokazi_a").style.display = "none";
				document.getElementById("pokazi_b").style.display = "none";
				document.getElementById("checkbox_a").style.display = "none";
				document.getElementById("b").style.display="none";
				document.getElementById("c").style.display = "none";
				document.getElementById("d").style.display = "none";
			} else if(val=="0") {
				document.getElementById("potvrdi").style.display = "inline";
				document.getElementById("pitanje").style.display = "inline";
				document.getElementById("checkbox_a").style.display = "inline";
				document.getElementById("pokazi_a").style.display = "inline";
				document.getElementById("a").style.display = "inline";
				document.getElementById("b").style.display = "inline";
				document.getElementById("c").style.display = "inline";
				document.getElementById("d").style.display = "inline";
				document.getElementById("pokazi_b").style.display = "inline";
			} else if(val=="2") {
				document.getElementById("potvrdi").style.display = "inline";
				document.getElementById("pitanje").style.display = "inline";
				document.getElementById("a").style.display = "inline";
				document.getElementById("checkbox_a").style.display = "inline";
				document.getElementById("pokazi_a").style.display = "none";
				document.getElementById("pokazi_b").style.display = "none";
				document.getElementById("b").style.display = "inline";
				document.getElementById("c").style.display = "none";
				document.getElementById("d").style.display = "none";
			}
		}
		function ValidateForm()
		{
			if ($('#tekst_pitanja').val()=="")
			{
					$('#greska').empty();
					$('#greska').append("Tekst pitanja ne može biti prazan");
					return false;
			}

			if (parseInt($('#bodovi').val())<1 || isNaN(parseInt($('#bodovi').val())))
			{
					$('#greska').empty();
					$('#greska').append("Potreban je smisleni broj bodova");
					return false;
			}
				if ($('#odgovor_a').val()=="" && $('#vrsta').val()=="1")
			{
					$('#greska').empty();
					$('#greska').append("Odgovor ne može biti prazan");
					return false;
			}
			if ($('#vrsta').val()=="0")
			{
				if($('#odgovor_a').val()=="" || $('#odgovor_b').val()=="" || $('#odgovor_c').val()=="" || $('#odgovor_d').val()=="")
				{
					$('#greska').empty();
					$('#greska').append("Odgovori ne mogu biti prazni");
					return false;
				}
				if(!($('#checkbox_a').is(':checked') || $('#checkbox_b').is(':checked')  || $('#checkbox_c').is(':checked')  || $('#checkbox_d').is(':checked') ))
				{
					$('#greska').empty();
					$('#greska').append("Barem jedan odgovor mora biti točan");
					return false;
				}
			}
			if ($('#vrsta').val()=="2")
			{
				if($('#odgovor_a').val()=="" || $('#odgovor_b').val()=="")
				{
					$('#greska').empty();
					$('#greska').append("Odgovori ne mogu biti prazni");
					return false;
				}
				if(!($('#checkbox_a').is(':checked') || $('#checkbox_b').is(':checked') ))
				{
					$('#greska').empty();
					$('#greska').append("Barem jedan odgovor mora biti točan");
					return false;
				}
			}
			$('#greska').empty();
			return True;
			
		}
		</script>
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
						<p class="lead text-center font-lg">Suggest question:</p>
					</div>
				</div>
			</div>
		</div>
		<div class="section red">
			<div class="container">
				<div class="row">
					<div class="col-sm-offset-3 col-sm-6 col-md-offset-4 col-md-4">
						<form action="add_question.php" method="POST" onsubmit="return ValidateForm()">
							<select id="vrsta" name="select" onchange='checkvalue(this.value)' onChange="javascript:changeCheckboxState(this);">
								<option value="default" disabled="disabled" selected="selected">Select</option>
								<option value="0">Multiple choice</option>
								<option value="1">Answer entry</option>
								<option value="2">True / False</option>
							</select>
							<div id="pitanje" style="display: none;">
								<p>Question: <input type="text" id="tekst_pitanja" name="tekst_pitanja" maxlength="100">
								Points: <input type="text" id="bodovi" name="bodovi"></p>
							</div>
							<div id="a" style="display: none;">
								<p><span id="pokazi_a">A: </span><input type="text" id="odgovor_a" name="odgovor_a" maxlegth="45">
								<input type="checkbox" id="checkbox_a" name="tocan_a"></p>
							</div>
							<select id="kategorije" name="kategorije">
						<?php
							db_connect();
							$result=mysqli_query($mysqli, "SELECT id_kategorija, naziv_kategorija FROM kategorija;");
							db_disconnect();
							while ($data=mysqli_fetch_array($result)) {
								echo "<option value='$data[id_kategorija]'>$data[naziv_kategorija]</option>";
							}
						?>
						</select> 
							<div id="b" style="display: none;">
								<p><span id="pokazi_b">B: </span><input type="text" id="odgovor_b" name="odgovor_b" maxlegth="45">
								<input type="checkbox" name="tocan_b" id="checkbox_b"></p>
							</div>
							<div id="c" style="display: none;">
								<p>C: <input type="text" id="odgovor_c" name="odgovor_c" maxlegth="45">
								<input type="checkbox" name="tocan_c" id="checkbox_c"></p>
							</div>
							<div id="d" style="display: none;">
								<p>D: <input type="text" id="odgovor_d" name="odgovor_d" maxlegth="45">
								<input type="checkbox" name="tocan_d" id="checkbox_d"></p>
							</div>
							<div id="potvrdi" style="display: none;">
								<p><input type="submit" value="Submit"></p>
							</div>
							</form> 
							<div id="greska"></div>
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
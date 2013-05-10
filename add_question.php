<?php
	session_start();

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$tekst=$_POST['tekst_pitanja'];
		$odgovor_a=$_POST['odgovor_a'];
		$odgovor_b=$_POST['odgovor_b'];
		$odgovor_c=$_POST['odgovor_c'];
		$odgovor_d=$_POST['odgovor_d'];
		$bodovi=$_POST['bodovi'];
		$vrsta=$_POST['select'];
		$jezik="hr";

		include 'config.php';
		db_connect();
	
		if (isset($_SESSION['user'])) {
		
			$user=$_SESSION['user'];
			$result=mysqli_query($mysqli, "SELECT id_korisnik FROM korisnik WHERE nadimak_korisnik = '$user';");
			$data=mysqli_fetch_array($result);
			$autor=$data['id_korisnik'];

			if($vrsta=="0"){
				//provjera da li su svi textboxi puni
				if(empty($_POST['tekst_pitanja']) || empty($_POST['odgovor_a']) || empty($_POST['odgovor_b']) || empty($_POST['odgovor_c']) || empty($_POST['odgovor_d']) || empty($_POST['bodovi'])) {
					print '<script type="text/javascript">';
					print 'alert("niste popunili sve textboxe")';
					print '</script>';  
				} else {
					//provjera da li su checkboxi checkirani, upisivanje pitanja i odg u bazu
					if(empty ($_POST['tocan_a']) && empty($_POST['tocan_b']) && empty($_POST['tocan_c']) && empty($_POST['tocan_d'])) {
						print '<script type="text/javascript">';
						print 'alert("niste odabrali nijedan odgovor")';
						print '</script>';  
					} else {
						mysqli_query($mysqli, "INSERT INTO `pitanje` (`tekst_pitanja`, `vrsta_pitanja`, `bodovi_pitanja`, `jezik_pitanja`, `id_autor`) VALUES ('$tekst', '$vrsta', '$bodovi', '$jezik', '$autor');");
						$id=mysqli_insert_id($mysqli);

						$tocan=1;
						if (empty($_POST['tocan_a'])) {
							$tocan=0;   
						}
						mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_a', '$tocan', '$id');"); 
			
					 	$tocan=1;
						if(empty($_POST['tocan_b'])) {
							$tocan=0;    
						}
						mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_b', '$tocan', '$id');");

						$tocan=1;
						if(empty($_POST['tocan_c'])) {
							$tocan=0;    
						}
						mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_c', '$tocan', '$id');");

						$tocan=1;
						if(empty($_POST['tocan_d'])) {
							$tocan=0;       
						}
						mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_d', '$tocan', '$id');");
					}
				}
			} else if($vrsta=="1") {
				if(empty($_POST['tekst_pitanja']) || empty($_POST['odgovor_a']) || empty($_POST['bodovi'])) {
					print '<script type="text/javascript">';
					print 'alert("niste popunili sve textboxe")';
					print '</script>';  
				} else {
					mysqli_query($mysqli, "INSERT INTO `pitanje` (`tekst_pitanja`, `vrsta_pitanja`, `bodovi_pitanja`, `jezik_pitanja`, `id_autor`) VALUES ('$tekst', '$vrsta', '$bodovi', '$jezik', '$autor');");
					$id=mysqli_insert_id($mysqli);
					mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `id_pitanje`) VALUES ('$odgovor_a', '$id');"); 
				}

			} else if ($vrsta=="2") {
				// TO-DO
			} else {
				print '<script type="text/javascript">';
				print 'alert("niste popunili sve textboxe")';
				print '</script>'; 
			}
		} else {
			print '<script type="text/javascript">';
			print 'alert("You are not logged in!")';
			print '</script>';
		}

	db_disconnect();
	}
?>

<!DOCTYPE html> 
<html>
<head>
	<title>Add question</title>
	<script language="javascript" type="text/javascript">
	function checkvalue(val) {
		if(val=="1") {
			document.getElementById("checkbox_a").style.visibility = "hidden";
			document.getElementById("glupost").style.visibility = "hidden";
			document.getElementById("b").style.visibility = "hidden";
			document.getElementById("c").style.visibility = "hidden";
			document.getElementById("d").style.visibility = "hidden";
		} else {
			document.getElementById("checkbox_a").style.visibility = "visible";
			document.getElementById("glupost").style.visibility = "visible";
			document.getElementById("a").style.visibility = "visible";
			document.getElementById("b").style.visibility = "visible";
			document.getElementById("c").style.visibility = "visible";
			document.getElementById("d").style.visibility = "visible";
		}
	}
	</script>
</head>
<body>
	<form action="add_question.php" method="POST">
	<select name="select" onchange='checkvalue(this.value)' onChange="javascript:changeCheckboxState(this);">
		<option value="default" disabled="disabled" selected="selected">Select</option>
		<option value="0">Visestruki izbor</option>
		<option value="1">Upisivanje odgovora</option>
		<option value="2">Tocno / Netocno</option>
	</select>
	<p>Pitanje: <input type="text" id="tekst_pitanja" name="tekst_pitanja" maxlength="100">
	Bodovi: <input type="text" name="bodovi"></p>
	<div id="a" style="visibility: visible;">
		<p><span id="glupost">a: </span><input type="text" id="odgovor_a" name="odgovor_a" maxlegth="45">
		<input type="checkbox" id="checkbox_a" name="tocan_a"></p>
	</div>
	<div id="b" style="visibility: visible;">
		<p>b: <input type="text" id="odgovor_b" name="odgovor_b" maxlegth="45">
		<input type="checkbox" name="tocan_b"></p>
	</div>
	<div id="c" style="visibility: visible;">
		<p>c: <input type="text" id="odgovor_c" name="odgovor_c" maxlegth="45">
		<input type="checkbox" name="tocan_c"></p>
	</div>
	<div id="d" style="visibility: visible;">
		<p>d: <input type="text" id="odgovor_d" name="odgovor_d" maxlegth="45">
		<input type="checkbox" name="tocan_d"></p>
	</div>
	<p><input type="submit" value="potvrdi" ></p>
	</form> 
</body>
</html>
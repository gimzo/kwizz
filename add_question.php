<?php
	session_start();
	include_once 'resources/config.php';
	header("Content-type: text/html; charset=utf-8");
	if (!isset($_SESSION['user'])) {
		header("Location: index.php");
		die();
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$tekst=$_POST['tekst_pitanja'];
		$odgovor_a=$_POST['odgovor_a'];
		$odgovor_b=$_POST['odgovor_b'];
		$odgovor_c=$_POST['odgovor_c'];
		$odgovor_d=$_POST['odgovor_d'];
		$bodovi=$_POST['bodovi'];
		$vrsta=$_POST['select'];
		$kategorija=$_POST['kategorije'];
		$jezik="hr";

		db_connect();
	
		if (isset($_SESSION['user'])) {
		
			$user=$_SESSION['user'];
			$result=mysqli_query($mysqli, "SELECT id_korisnik FROM korisnik WHERE nadimak_korisnik = '$user';");
			$data=mysqli_fetch_array($result);
			$autor=$data['id_korisnik'];

			if($vrsta=="0"){
				//provjera da li su svi textboxi puni
				if(empty($_POST['tekst_pitanja']) || empty($_POST['odgovor_a']) || empty($_POST['odgovor_b']) || empty($_POST['odgovor_c']) || empty($_POST['odgovor_d']) || empty($_POST['bodovi'])) {
				} else {
					//provjera da li su checkboxi checkirani, upisivanje pitanja i odg u bazu
					if(empty ($_POST['tocan_a']) && empty($_POST['tocan_b']) && empty($_POST['tocan_c']) && empty($_POST['tocan_d'])) {
					} else {
						mysqli_query($mysqli, "INSERT INTO `pitanje` (`tekst_pitanja`, `vrsta_pitanja`, `bodovi_pitanja`, `jezik_pitanja`, `id_autor`) VALUES ('$tekst', '$vrsta', '$bodovi', '$jezik', '$autor');");
						$id=mysqli_insert_id($mysqli);
						mysqli_query($mysqli, "INSERT INTO `pitanje_kategorija` VALUES ('$id', '$kategorija');");
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
				} else {
					mysqli_query($mysqli, "INSERT INTO `pitanje` (`tekst_pitanja`, `vrsta_pitanja`, `bodovi_pitanja`, `jezik_pitanja`, `id_autor`) VALUES ('$tekst', '$vrsta', '$bodovi', '$jezik', '$autor');");
					$id=mysqli_insert_id($mysqli);
					mysqli_query($mysqli, "INSERT INTO `pitanje_kategorija` VALUES ('$id', '$kategorija');");
					mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `id_pitanje`) VALUES ('$odgovor_a', '$id');"); 
				}

			} else if ($vrsta=="2") {
				if(empty($_POST['tekst_pitanja']) || empty($_POST['odgovor_a']) || empty($_POST['odgovor_b']) || empty($_POST['bodovi'])) {
				} else {
					if(empty ($_POST['tocan_a']) && empty($_POST['tocan_b'])) {
					} else {
						mysqli_query($mysqli, "INSERT INTO `pitanje` (`tekst_pitanja`, `vrsta_pitanja`, `bodovi_pitanja`, `jezik_pitanja`, `id_autor`) VALUES ('$tekst', '0', '$bodovi', '$jezik', '$autor');");
						$id=mysqli_insert_id($mysqli);
						mysqli_query($mysqli, "INSERT INTO `pitanje_kategorija` VALUES ('$id', '$kategorija');");
						$tocan=1;
						if(empty($_POST['tocan_a'])) {
							$tocan=0;
						}
						mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_a', '$tocan', '$id');"); 

						$tocan=1;
						if(empty($_POST['tocan_b'])) {
							$tocan=0;
						}
						mysqli_query($mysqli, "INSERT INTO `odgovor` (`tekst_odgovor`, `tocan_odgovor`, `id_pitanje`) VALUES ('$odgovor_b', '$tocan', '$id');");
					} 	
				}			
			}header('Location: profile.php');
		} 
		}

	db_disconnect();
?>

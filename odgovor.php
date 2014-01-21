<?php
	session_start();
	include_once 'config.php';
	
	if (!isset($_SESSION['user'])) {
		die();
	}
	$user=$_SESSION['user'];
	if (!(isset($_POST['id']) || isset($_POST['odgovor']))) die();
	$id_odgovora=$_POST['id'];
	
	db_connect();
	$odgovor=$_POST['odgovor']=="true"?true:false;
	$result=mysqli_query($mysqli, "SELECT id_korisnik FROM korisnik WHERE nadimak_korisnik = '$user';");
	$data=mysqli_fetch_array($result);
	$autor=$data['id_korisnik'];
	$result=mysqli_query($mysqli, "INSERT INTO odgovorena_pitanja VALUES($autor , $id_odgovora , NOW(), '$odgovor' );");
	if ($odgovor){
		$result=mysqli_query($mysqli, "SELECT bodovi_pitanja FROM pitanje WHERE id_pitanje = $id_odgovora;");
		$data=mysqli_fetch_array($result);
		$bodovi=intval($data['bodovi_pitanja']);
		$result=mysqli_query($mysqli, "UPDATE rezultat SET rezultat=(rezultat+$bodovi) WHERE id_korisnik=$autor AND id_mode=0;");
		if (mysqli_affected_rows($mysqli)<1)$result=mysqli_query($mysqli, "INSERT INTO rezultat VALUES ($autor, 0, $bodovi);");
	}
	db_disconnect();
	
?>

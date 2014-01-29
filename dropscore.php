<?php
	session_start();
	include_once 'resources/config.php';
	header("Content-type: text/html; charset=utf-8");
	if (!isset($_SESSION['user'])) {
		header("Location: index.php");
		die();
	}
	
	$user=$_SESSION['user'];
	
	db_connect();
	$result=mysqli_query($mysqli, "SELECT id_korisnik FROM korisnik WHERE nadimak_korisnik = '$user';");
	$data=mysqli_fetch_array($result);
	$autor=$data['id_korisnik'];
	$rezultat=mysqli_query($mysqli,"DELETE FROM rezultat WHERE id_korisnik=$autor;");
	$rezultat=mysqli_query($mysqli,"DELETE FROM odgovorena_pitanja WHERE id_korisnik=$autor;");
	db_disconnect();
	header('Location: profile.php');

?>

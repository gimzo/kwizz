<?php

	session_start();
	include_once 'config.php';

	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}
	$user=$_SESSION['user'];
	db_connect();
	$result=mysqli_query($mysqli, "SELECT id_korisnik FROM korisnik WHERE nadimak_korisnik = '$user';");
	$data=mysqli_fetch_array($result);
	$autor=$data['id_korisnik'];
	$rezultat=mysqli_query($mysqli,"DELETE FROM rezultat WHERE id_korisnik=$autor;");
	db_disconnect();

?>

<?php

	include_once 'config.php';
	session_start();
	if (!isset($_SESSION['user'])) {
		die();
	}
	$user=$_SESSION['user'];
	db_connect();
	$result=mysqli_query($mysqli, "SELECT id_korisnik FROM korisnik WHERE nadimak_korisnik = '$user';");
	$data=mysqli_fetch_array($result);
	$autor=$data['id_korisnik'];
	$rezultat=mysqli_query($mysqli,"SELECT rezultat FROM rezultat NATURAL JOIN korisnik WHERE id_mode=0 AND id_korisnik=$autor;");
	db_disconnect();
	if ($rezultat->num_rows > 0){
	$data=mysqli_fetch_array($rezultat);
	echo intval($data['rezultat']);
}else echo 0;
?>

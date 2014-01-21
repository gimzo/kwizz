<?php
	session_start();

	include_once 'config.php';

	if (!isset($_SESSION['user'])) {
		header('Location: index.php');
	}

	$id=$_SESSION['id'];
	db_connect();								
	$result=mysqli_query($mysqli, "SELECT lista_prijatelja.id_prijatelj AS id, nadimak_korisnik AS nick FROM lista_prijatelja INNER JOIN korisnik ON korisnik.id_korisnik=lista_prijatelja.id_prijatelj WHERE id_vlasnik='$id';");
	while ($data=mysqli_fetch_array($result)) {
		echo $data['nick']."<br>";
	}

?>
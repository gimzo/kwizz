<?php
	session_start();

	// Ako je korisnik ulogiran izvrsava sign out
	if (isset($_SESSION['user'])) {
		// Oslobada sve varijable sesije
		session_unset();
		// Unistava sve podatka registrirane u sesiji
		session_destroy();
		// Pridruzuje prazno polje sesiji
		$_SESSION = array();
	}
	
	// Preusmjeravanje na index.php nakon sign out-a ili posjeta neulogiranom korisniku
	header('Location: index.php');
?>
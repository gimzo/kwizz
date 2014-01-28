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
	<title>Friends</title>
</head>
<body>
	<table border="1" width="50%">
		<tr>
			<td>
				<form action='friends.php' method='GET'>
					<input type="text" name="nick">
					<button type="submit">Submit</button>
				</form>
				<?php
					db_connect();
					if (!empty($_GET['nick'])) {
						$nadimak=$_GET['nick'];
						$result=mysqli_query($mysqli, "SELECT nadimak_korisnik FROM korisnik WHERE (nadimak_korisnik like '%$nadimak%' OR ime like '%$nadimak%') AND id_korisnik NOT IN (SELECT id_prijatelj FROM lista_prijatelja WHERE id_vlasnik='$_SESSION[id]')");
						echo "Results:<br>";
						while ($data=mysqli_fetch_array($result)) {
							echo "<a href='profile.php?nickname=".$data['nadimak_korisnik']."'>".$data['nadimak_korisnik']."</a><br>";
						}
					}		
				?>
			</td>
			<td>
				<?php 
					$id=$_SESSION['id'];						
					$result=mysqli_query($mysqli, "SELECT lista_prijatelja.id_prijatelj AS id, nadimak_korisnik AS nick FROM lista_prijatelja INNER JOIN korisnik ON korisnik.id_korisnik=lista_prijatelja.id_prijatelj WHERE id_vlasnik='$id';");
					echo "Friends:<br><br>";
					while ($data=mysqli_fetch_array($result)) {
						echo "<a href='profile.php?nickname=".$data['nick']."'>".$data['nick']."</a><br>";
					}
				?>
			</td>
		</tr>
	</table>
	
</body>
</html>
	
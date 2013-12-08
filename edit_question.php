<?php
	include_once 'config.php';
	$id=$_GET['question'];

	db_connect();
	$query=mysqli_query($mysqli, "SELECT * FROM pitanje WHERE id_pitanje='$id';");
	$result=mysqli_fetch_array($query);
	echo "<form action='save_changes.php' method='GET'>";
	echo "<input type='hidden' name='id' value='$id'>";
	echo "<input type='text' value='".$result['tekst_pitanja']."' name='question' style='width: 300px;'><br>";
	$row=mysqli_query($mysqli, "SELECT * FROM odgovor WHERE id_pitanje='$id';");
	$i=0;

	while($answer=mysqli_fetch_array($row)) {
		$i++;
			if($answer['tocan_odgovor']==1) {
				echo "Tocan odgovor je $i): <input type='text' value='".$answer['tekst_odgovor']."' name='tocan'><br>";
				echo "<input type='hidden' name='id_tocan' value='".$answer['id_odgovor']."'>";
			} else {
				echo "$i)<input type='text' value='".$answer['tekst_odgovor']."' name='answer".$i."'><br>";
				echo "<input type='hidden' name='id_ans".$i."' value='".$answer['id_odgovor']."'>";
			}
			echo "&nbsp;";
	}
	echo "<input type='submit' value='Potvrdi' name='potvrdi'>";
	echo "</form>";
	
?>
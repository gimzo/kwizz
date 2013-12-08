<?php
	include_once 'config.php';
	
	if ($_SERVER['REQUEST_METHOD']==='POST') {
		db_connect();
		if (isset($_POST['potvrdi'])) {
			if (!empty($_POST['odobreno'])) {
    			foreach($_POST['odobreno'] as $check) {
           			$result=mysqli_query($mysqli, "UPDATE pitanje SET odobreno_pitanje=1 WHERE id_pitanje='$check';");
            	}
    		}
		} else if (isset($_POST['obrisi'])) {
			if (!empty($_POST['odobreno'])) {
    			foreach($_POST['odobreno'] as $check) {
           			$result=mysqli_query($mysqli, "DELETE FROM pitanje WHERE id_pitanje='$check';");
            	}
    		}
		} 
		db_disconnect();
	}
	
	db_connect();
	$result=mysqli_query($mysqli, "SELECT * FROM pitanje WHERE odobreno_pitanje=0;");
	echo "<form method='POST' action='admin.php'>";
	while ($data=mysqli_fetch_array($result)) {
		$id = $data['id_pitanje'];
		echo "<b>".$data['tekst_pitanja']."</b><input type='checkbox' name='odobreno[]' value='".$id."'>";
		echo "<a href='edit_question.php?question=".$data['id_pitanje']."'>Uredi</a><br>";
		$odgovor=mysqli_query($mysqli, "SELECT * FROM odgovor WHERE id_pitanje='$id';");
		$i=0;
		while ($answer=mysqli_fetch_array($odgovor)) {
			$i++;
			if($answer['tocan_odgovor']==1) {
				echo "Tocan odgovor je: $i) ".$answer['tekst_odgovor'];
			} else {
				echo "$i) ".$answer['tekst_odgovor'];
			}
			echo "&nbsp;";
		}
		echo "<br><br>";
	}
	echo "<input type='submit' value='Potvrdi' name='potvrdi'>";
	echo "<input type='submit' value='Obrisi' name='obrisi'>";
	echo "</form>";
	db_disconnect();
?>
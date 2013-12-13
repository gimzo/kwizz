<?php
	include_once 'config.php';

	if ($_SERVER['REQUEST_METHOD']==='GET') {
		db_connect();
		if (isset($_GET['potvrdi'])) {
			$question=$_GET['question'];
			$id=$_GET['id'];
			$points=$_GET['points'];
			$result=mysqli_query($mysqli, "UPDATE pitanje SET tekst_pitanja='$question' where id_pitanje='$id';");
			$result1=mysqli_query($mysqli, "UPDATE pitanje SET bodovi_pitanja='$points' where id_pitanje='$id';");
			if (!empty($_GET['tocan']) && !empty($_GET['id_tocan'])) {
				$tocan=$_GET['tocan'];
				$id_tocan=$_GET['id_tocan'];
				$result6=mysqli_query($mysqli, "UPDATE odgovor SET tekst_odgovor='$tocan' WHERE id_odgovor='$id_tocan';");
			}
			if(!empty($_GET['answer1']) && !empty($_GET['id_ans1'])) {
				$answer1=$_GET['answer1'];
				$id_ans1=$_GET['id_ans1'];
				$result2=mysqli_query($mysqli, "UPDATE odgovor SET tekst_odgovor='$answer1' WHERE id_odgovor='$id_ans1';");
			} 
			if(!empty($_GET['answer2']) && !empty($_GET['id_ans2'])) {
				$answer2=$_GET['answer2'];
				$id_ans2=$_GET['id_ans2'];
				$result3=mysqli_query($mysqli, "UPDATE odgovor SET tekst_odgovor='$answer2' WHERE id_odgovor='$id_ans2';");
			} 
			if(!empty($_GET['answer3']) && !empty($_GET['id_ans3'])) {
				$answer3=$_GET['answer3'];
				$id_ans3=$_GET['id_ans3'];
				$result4=mysqli_query($mysqli, "UPDATE odgovor SET tekst_odgovor='$answer3' WHERE id_odgovor='$id_ans3';");
			} 
			if(!empty($_GET['answer4']) && !empty($_GET['id_ans4'])) {
				$answer4=$_GET['answer4'];
				$id_ans4=$_GET['id_ans4'];
				$result5=mysqli_query($mysqli, "UPDATE odgovor SET tekst_odgovor='$answer4' WHERE id_odgovor='$id_ans4';");
			}	
		}
		header("Location: admin.php");	
	}
?>
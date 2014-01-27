<!DOCTYPE html>
<html>
<head>
	<title>Admin page</title>
	<script language="JavaScript">
		function Select() {
			var inputs=document.getElementsByTagName("input");
			for(var i=0; i<inputs.length; i++) {
				if(inputs[i].type=="checkbox") {
					inputs[i].checked=true;
				}
			}
		}
		function Deselect() {
			var inputs=document.getElementsByTagName("input");
			for(var i=0; i<inputs.length; i++) {
				if(inputs[i].type=="checkbox") {
					inputs[i].checked=false;
				}
			}
		}
	</script>
</head>
<body>
	<?php
		include_once 'resources/config.php';
	
		if ($_SERVER['REQUEST_METHOD']==='POST') {
			db_connect();
			if (isset($_POST['potvrdi'])) {
				if (!empty($_POST['neodobreno'])) {
    				foreach($_POST['neodobreno'] as $check) {
           				$result=mysqli_query($mysqli, "UPDATE pitanje SET odobreno_pitanje=1 WHERE id_pitanje='$check';");
            		}
    			}
			} else if (isset($_POST['obrisi'])) {
				if (!empty($_POST['neodobreno'])) {
    				foreach($_POST['neodobreno'] as $check) {
           				$result=mysqli_query($mysqli, "DELETE FROM pitanje WHERE id_pitanje='$check';");
            		}
            	} else if (!empty($_POST['odobreno'])) {
            		foreach ($_POST['odobreno'] as $check) {
            			$result=mysqli_query($mysqli, "DELETE FROM pitanje WHERE id_pitanje='$check';");
            		}
            	}
			}	 
			db_disconnect();
		}
	?>
	<table border="1" width="50%">
		<tr>
			<th>
				Accepted questions
			</th>
			<th>
				Not (yet) accepted
			</th>
		</tr>
		<tr>
			<td>
				<?php
					db_connect();
					$result=mysqli_query($mysqli, "SELECT * FROM pitanje WHERE odobreno_pitanje=1;");
					echo "<form method='POST' action='admin.php'>";
					while ($data=mysqli_fetch_array($result)) {
						$id = $data['id_pitanje'];
						echo "<b>".$data['tekst_pitanja']."</b><input type='checkbox' name='odobreno[]' value='".$id."'>";
						echo "<a href='edit_question.php?question=".$data['id_pitanje']."'>Uredi</a><br>";
						echo "Bodovi:" .$data['bodovi_pitanja']."<br>";
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
					db_disconnect();
				?>
			</td>
			<td>
				<?php
					db_connect();
					$result=mysqli_query($mysqli, "SELECT * FROM pitanje WHERE odobreno_pitanje=0 limit 20;");
					echo "<form method='POST' action='admin.php'>";
					while ($data=mysqli_fetch_array($result)) {
						$id = $data['id_pitanje'];
						echo "<b>".$data['tekst_pitanja']."</b><input type='checkbox' name='neodobreno[]' value='".$id."'>";
						echo "<a href='edit_question.php?question=".$data['id_pitanje']."'>Uredi</a><br>";
						echo "Bodovi:" .$data['bodovi_pitanja']."<br>";
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
					db_disconnect();
				?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="Potvrdi" name="potvrdi">
				<input type="submit" value="Obrisi" name="obrisi">
				<input type="button" onclick="Select();" value="Oznaci sve">
				<input type="button" onclick="Deselect();" value="Odznaci sve">
			</td>
		</tr>
	</table>
	</form>
</body>
</html>


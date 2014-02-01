<div class="container">
	<div class="row">
		<h3 class="text-center"><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Categories:</h3><br><br>
		<?php
		db_connect();
		// Nadkategorije
		$stmt = $mysqli->prepare("SELECT id_kategorija, naziv_kategorija FROM kategorija WHERE nadkategorija IS NULL");
		$stmt->execute();
		$res = $stmt->get_result();

		// Podkategorije
		$stmt2 = $mysqli->prepare("SELECT id_kategorija, naziv_kategorija FROM kategorija WHERE nadkategorija=? LIMIT 5");
		// Broj pitanja u kategoriji
		$stmt3 = $mysqli->prepare("SELECT COUNT(*) FROM pitanje_kategorija WHERE id_kategorija=?");

		while ($category = $res->fetch_array()) {
			echo '
			<div class="col-sm-4 col-md-3">
				<h4 class="text-center">'.$category['naziv_kategorija'].'</h4>
				<div class="list-group">';
					$stmt2->bind_param('i', $category['id_kategorija']);
					$stmt2->execute();
					$res2 = $stmt2->get_result();
					while ($subcategory = $res2->fetch_array()) {
						$stmt3->bind_param('i', $subcategory['id_kategorija']);
						$stmt3->execute();
						$res3 = $stmt3->get_result();
						$qcount = $res3->fetch_array();
						echo '
						<a href="play.php?category='.$subcategory['id_kategorija'].'" class="list-group-item"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;&nbsp;'.$subcategory['naziv_kategorija'].($qcount[0] > 0 ? '<span class="badge">'.$qcount[0].'</span>' : '').'</a>
						';
					}
					echo '
				</div>
			</div>
			';
		}
		
		$stmt3->close();
		$stmt2->close();
		$stmt->close();
		db_disconnect();
		?>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-12"><h3><span class="glyphicon glyphicon-th"></span>&nbsp;&nbsp;Categories:</h3><br><br></div>
		<div class="row">
			<?php
			db_connect();
							// Nadkategorije
			$stmt = $mysqli->prepare("SELECT id_kategorija, naziv_kategorija FROM kategorija WHERE nadkategorija IS NULL");
			$stmt->execute();
			$res = $stmt->get_result();

							// Podkategorije
			$stmt2 = $mysqli->prepare("SELECT id_kategorija, naziv_kategorija FROM kategorija WHERE nadkategorija=? LIMIT 5");

			while ($category = $res->fetch_array()) {
				echo '
				<div class="col-sm-4 col-md-3">
					<h4 class="text-center">'.$category['naziv_kategorija'].'</h4>
					<div class="list-group">';
						$stmt2->bind_param('i', $category['id_kategorija']);
						$stmt2->execute();
						$res2 = $stmt2->get_result();
						while ($subcategory = $res2->fetch_array()) {
							echo '
							<a href="play.php?category='.$subcategory['id_kategorija'].'" class="list-group-item"><span class="glyphicon glyphicon-chevron-right"></span>&nbsp;&nbsp;'.$subcategory['naziv_kategorija'].'</a>
							';
						}
						echo '
					</div>
				</div>
				';
			}
			
			$stmt2->close();
			$stmt->close();
			db_disconnect();
			?>
		</div>
	</div>
</div>
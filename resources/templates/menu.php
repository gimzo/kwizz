<div class="section-sm green">
	<div class="container">
		<ul class="nav nav-pills">
			<li><a href="index.php"><span class="glyphicon glyphicon-home"></span>&nbsp;&nbsp;Home</a></li>
			<li><a href="play.php"><span class="glyphicon glyphicon-play"></span>&nbsp;&nbsp;Play</a></li>
			<li><a href="live.php"><span class="glyphicon glyphicon-transfer"></span>&nbsp;&nbsp;LivePlay</a></li>
			<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Profile</a></li>
			<li><a href="friends.php"><span class="glyphicon glyphicon-globe"></span>&nbsp;&nbsp;Friends</a></li>
			<li><a href="messages.php"><span class="glyphicon glyphicon-comment"></span>&nbsp;&nbsp;Messages</a></li>
			<li><a href="rankings.php"><span class="glyphicon glyphicon-stats"></span>&nbsp;&nbsp;Rankings</a></li>
			<li class="pull-right"><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Logout</a></li>
			<?php
				db_connect();
				// Ime kategorije
				$stmt = $mysqli->prepare("SELECT uloga_korisnik FROM korisnik WHERE id_korisnik=?");
				$stmt->bind_param('i', $_SESSION['id']);
				$stmt->execute();
				$res = $stmt->get_result();
				$row = $res->fetch_array();
				$stmt->close();

				db_disconnect();

				// If user has admin permissions show admin panel link
				if ($row['uloga_korisnik'] == 0) {
					echo '<li class="pull-right"><a href="admin.php"><span class="glyphicon glyphicon-wrench"></span>&nbsp;&nbsp;Admin</a></li>';
				}
			?>
		</ul>
	</div>
</div>
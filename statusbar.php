<?php
	if (isset($_SESSION['user'])) {
		$user=$_SESSION['user'];
echo <<<END
		<div id='statusBar' class='horCenter displayTable'>
			<div class='vertMiddle'>
				<p>Logged in as: <a href='profile.php'>$user</a> | <a href='logout.php'>Logout</a></p>
			</div>
		</div>
END;
	} else {
echo <<<END
		<div id='statusBar' class='horCenter displayTable'>
			<div class='vertMiddle'>
				<p><a href='login.php'>Login</a> | <a href='register.php'>Register</a></p>
			</div>
		</div>
END;
	}
?>
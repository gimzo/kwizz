<?php
	if (isset($_SESSION['user'])) {
		$user=$_SESSION['user'];
echo <<<END
		<p class="navbar-text pull-right">Logged in as <a href="profile.php" class="navbar-link">$user</a> | <a href="logout.php" class="navbar-link">Logout</a></p>
END;
	} else {
echo <<<END
		<p class="navbar-text pull-right"><a href="login.php" class="navbar-link">Log In</a> | <a href="register.php" class="navbar-link">Sign Up</a></p>
END;
	}
?>
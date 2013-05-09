<?php
	if (isset($_SESSION['user'])) {
		$user=$_SESSION['user'];
echo <<<END
		<div id="loginBar">
			<div class="floatR">
				<form action="index.php" method="post" accept-charset="UTF-8">
					<input type="submit" name="Submit" value="Logout" />
				</form>
			</div>
			<div class="floatR">Welcome <a href="profile.php">$user</a>, have a nice stay!</div>
		</div>
END;
	} else {
echo <<<END
		<div id="loginBar">
			<a href="register.php" class="floatR">Register</a>
			<div class="floatR">
				<form action="index.php" method="post" accept-charset="UTF-8">
					<label for"nickname">Nickname:</label>
					<input type="text" name="nickname" maxlength="20" />
					<label for="password">Password:</label>
					<input type="password" name="password" maxlength="45" />
					<input type="submit" name="Submit" value="Submit" />
				</form>
			</div>
		</div>
END;
	}
?>
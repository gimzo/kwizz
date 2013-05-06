<!DOCTYPE html> 
<html>
<head>
	<title>Register</title>
</head>
<body>
	<form id='register' action='register.php' method='post'
    accept-charset='UTF-8'>
	<fieldset >
		<legend>Register</legend>
		<label for='nickname' >Desired Nickname: </label>
		<input type='text' name='nickname' id='nickname' maxlength="20" />
		<label for='password' >Password:</label>
		<input type='password' name='password' id='password' maxlength="45" />
 		<label for='country' >Country:</label>
		<input type='text' name='country' id='country' maxlength="2" />
		<input type='submit' name='Submit' value='Submit' />
	</fieldset>
	</form>
</body>
</html>
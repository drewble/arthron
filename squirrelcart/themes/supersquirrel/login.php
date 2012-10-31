	<form action="" method="post" style="margin: 0">
		Username: <input style="width: 80"size="12" type="text" name="username"><br>
		Password: <input style="margin-left: 2px; width: 80" size="12" type="password" name="password"><br>
		<input type="hidden" name="login_action" value="attempt">
		<input type="hidden" name="show_login" value="0">
		<input style="margin-top: 5;" type="submit" value="Login">
		<?=$Error?><br>
		<?=$Forgotten_Password_Link?><br><?=$New_Account_Link?>
	</form>
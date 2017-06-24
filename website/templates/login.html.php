<form class="editor" Method='post'>
	<input type="hidden" value="<?= htmlspecialchars($token) ?>" name="token"></input>
	<label>Email</label>
	<input type="text" name="email" value="<?= (isset($email)) ? $email: ""?>">
	<label>Passwort</label>
	<input type='password' name='password'>
	<p style="color:red"><?= htmlspecialchars($error)?></p>
	<input type="submit" value="Login">	
	<a href="/register">Not yet registered?</a><br/>
	<a href="/forgot">Forgot Password?</a>
</form>

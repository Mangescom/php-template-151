<form class="editor" Method='post'>
	<label>Vorname</label>
	<input type='Text' name='vorname'>


	<label>Nachname</label>
	<input type='Text' name='nachname'>


	<label>Email</label>
	<input type='Text' name='email'>


	<label>Passwort</label>
	<input type='Password' name='password1'>


	<label>Passwort bestätigen</label>
	<input type='Password' name='password2'>

	<p style="color:red"><?= htmlspecialchars($error)?></p>

	<input type="submit" value="Registrieren">
</form>
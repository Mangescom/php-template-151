
<form class="editor" method="post" action="/changepw">
	<h2>Hi there, <?php echo $_SESSION["username"];?></h2>
	<a href="/logout">Logout here</a>
	<input type="hidden" value="<?= htmlspecialchars($token) ?>" name="token"></input>
	<h2>Change Password</h2>
	<label>Old Password</label>
	<input type="password" name="oldPW"/>
	<label>New Password</label>
	<input type="password" name="newPW"/>
	<label>Repeat Password</label>
	<input type="password" name="repPW"/>
	<p style="color:red;"><?= htmlspecialchars($error)?></p>
	<input type="submit"></input>
</form>

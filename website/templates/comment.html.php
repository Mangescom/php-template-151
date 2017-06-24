<br/>
<form method="post" action="comment" class="editor">
<h3>Write a comment</h3>	
	<input type="hidden" name="id" value="<?= htmlspecialchars($id)?>">
	<input type="hidden" value="<?= htmlspecialchars($token)?>" name="token"></input>
	<input type="text" name="comment" style="width: 100%"></input>
	<input type="submit" value="post"/>
</form>
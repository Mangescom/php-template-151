<form class="editor" Method='post' action="/postvideo">
	<input type="hidden" value="<?= htmlspecialchars($token) ?>" name="token"></input>
	<input type="hidden" value="<?= htmlspecialchars($id)?>" name="id"></input>	
	<label>Title</label>
	<input type='Text' name='title' value="<?= htmlspecialchars($title)?>"></input>
	<label>Url</label>
	<input type='Text' name='url' value="<?= htmlspecialchars($url)?>"></input>
	<input type="submit" value="Post"></input>
	<a href="deletevideo?id=<?= htmlspecialchars($id)?>" onclick="return confirm('Are you sure to delete this post?')">Delete this Video</a>
</form>
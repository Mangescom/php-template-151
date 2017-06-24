<form class="editor" Method='post' action="/postblog">
	<input type="hidden" value="<?= htmlspecialchars($token) ?>" name="token"></input>
	<input type="hidden" value="<?= htmlspecialchars($id)?>" name="id"></input>	
	<label>Title</label>
	<input type='Text' name='title' value="<?= htmlspecialchars($title)?>"></input>
	<label>Text</label>
	<input type='Text' name='text' value="<?= htmlspecialchars($text)?>"></input>
	<label>Image</label>
	<input type='Text' name='image' value="<?= htmlspecialchars($image)?>"></input>
	<input type="submit" value="Post"></input>
	<a href="deletepost?id=<?= htmlspecialchars($id)?>" onclick="return confirm('Are you sure to delete this post?')">Delete this Post</a>
</form>
<div class="post">
	<h3><?= htmlspecialchars($created)?>, <?= htmlspecialchars($author)?></h3>
	<img onerror="this.style.display='none'" src="<?= htmlspecialchars($image)?>">
	<h1><?= htmlspecialchars($title)?></h1>
	<p><?= htmlspecialchars($text)?></p>
	<a href="/blogpost?id=<?= htmlspecialchars($id)?>">Read More</a>
	<?php
		if(isset($_SESSION["admin"])){
			echo '<a href="blogedit?id='.htmlspecialchars($id).'">Edit</a>';
		}
	?>
</div>
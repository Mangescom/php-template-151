<div class="post">
	<h3><?= htmlspecialchars($posted)?>, <?= htmlspecialchars($author)?></h3>
	<iframe src="https://www.youtube.com/embed/<?= htmlspecialchars($url)?>"></iframe>
	<h1><?= htmlspecialchars($title)?></h1>	
	<?php 
		if(isset($_SESSION["admin"])){
			echo '<a href="videoedit?id='.htmlspecialchars($id).'">Edit</a>';
		}
	?>
</div>
<!DOCTYPE html>
<html lang="ru">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<div class="gallery">
			<div class="top-line">	
			</div>
			<div class="container">
				<?php include(ROOT . '/views/layouts/_burger.php'); ?>
				<div class="gallery__grid">
					<?php foreach($photos as $photo) {
						if ($minId == NULL || $photo['id'] < $minId)
							$minId = $photo['id'];
					?>
						<img class="gallery__grid-item" src="/Camagru/public/images/gallery/<?php echo($photo['user_id'] . '/' . $photo['photo_src']); ?>">
					<?php } ?>
				</div>
				<input class="button button_bg_pink gallery__show-more" type="button" value="Показать больше" data-id="<?php echo($minId); ?>">
			</div>
		</div>
		<script src="/Camagru/public/js/ajax.js"></script>
		<script src='/Camagru/public/js/show-more.js'></script>
	</body>
</html>
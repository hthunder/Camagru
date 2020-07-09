<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<div class="gallery main-content">
			<div class="top-line">	
			</div>
			<?php include(ROOT . '/views/layouts/_header.php') ?>
			<div class="container">
				<?php include(ROOT . '/views/layouts/_burger.php'); ?>
				<div class="gallery__grid">
					{gallery__grid}	
				</div>
				<input class="button button_bg_pink gallery__show-more" type="button" value="Показать больше" data-id="{min_id}">
			</div>
		</div>
		<?php include(ROOT . '/views/layouts/_footer.php'); ?>
		<script src="/public/js/ajax.js"></script>
		<script src='/public/js/show-more.js'></script>
	</body>
</html>

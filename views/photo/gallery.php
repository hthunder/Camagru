<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<header class="header {transparency}">
			{burger}
		</header>
		<div class="gallery main-content">
			<div class="container">
				<div class="gallery__grid">
					{gallery__grid}	
				</div>
				<?php include(ROOT . "/views/layouts/_pagination/_pagination.php"); ?>
			</div>
		</div>
		<?php include(ROOT . '/views/layouts/_footer.php'); ?>
		<script src="/public/js/app.js"></script>
		<script src="/public/js/ajax.js"></script>
	</body>
</html>

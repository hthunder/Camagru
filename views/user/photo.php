<!DOCTYPE html>
<html lang="ru">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<div class="photo">
			<div class="top-line">	
			</div>
			<div class="container">
				<?php include(ROOT . '/views/layouts/_burger.php'); ?>
				<?php 
					if(isset($_SESSION['errors'])) {
						echo($_SESSION['errors']);
						unset($_SESSION['errors']);
					} 
				?>
				<div class="photo__container">
					<?php include(ROOT . '/views/layouts/_mask-control.php'); ?>
					<video class="photo__video" id="video">Video stream not available.</video>
					<form class="photo__form" action="/Camagru/photo/create" method="POST">
						<input class="photo__hidden" type="hidden" name="hidden">
						<input class="photo__hidden-info" type="hidden" name="info">
						<button class="button-4 photo__button" type="button"  id="startbutton">
							<div class="photo__button-wrapper">
								<img class="button-4__img" src="/Camagru/public/images/icons/camera_white.svg" alt="">
							</div>			
						</button>
					</form>
				</div>
				<?php include(ROOT . '/views/layouts/_slider.php'); ?>
				<form class="photo__custom-input custom-input">
					<input class="custom-input__file" type="file" name="uploadfile" id="custom-file" required>
					<label class="custom-input__label" for="custom-file">
						<span class="custom-input__span">Выбрать файл&hellip;</span>
					</label>
				</form>
				<input class="button-2 button-2_inverse" type="button" value="Опубликовать">
				<canvas id="canvas" style="display: none">
				</canvas>
			</div>
		</div>
		<script src="/Camagru/public/js/main.js"></script>
		<script src="/Camagru/public/js/video.js"></script>
		<script src="/Camagru/public/js/slider.js"></script>
		<script src="/Camagru/public/js/custom-file-input.js"></script>
		<script src="/Camagru/public/js/preview.js"></script>
	</body>
</html>
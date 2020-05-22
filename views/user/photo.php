<!DOCTYPE html>
<html lang="ru">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<div class="photo">
			<div class="top-line">	
			</div>
			<div class="container">
				<?php include(ROOT . '/views/layouts/_burger.php'); ?>
				<form action="/Camagru/photo/create" method="POST" enctype="multipart/form-data">
					<input type="file" name="uploadfile" required>
					<input type="submit" value="Загрузить">
				</form>
				<?php 
					if(isset($_SESSION['errors'])) {
						echo($_SESSION['errors']);
						unset($_SESSION['errors']);
					} 
				?>
				<div class="photo__container">
					<div class="photo__nav-container">
						<button class="photo__nav-button photo__nav-button_up">&#708;</button>
						<div class="photo__nav-center">
							<button class="photo__nav-button photo__nav-button_left"><</button>
							<button class="photo__nav-button photo__nav-button_right">></button>	
						</div>
						<button class="photo__nav-button photo__nav-button_down">&#709;</button>
					</div>
					<div class="photo__scale-container">
						<button class="photo__scale-button photo__scale_up">+</button>
						<button class="photo__scale-button photo__scale_down">-</button>
					</div>
					<video class="photo__video" id="video">Video stream not available.</video>
					<form action="/Camagru/photo/create">
						<button class="button-4 photo__button" id="startbutton">
							<img class="button-4__img" src="/Camagru/public/images/icons/camera_white.svg" alt="">
						</button>
					</form>
				</div>
				<?php include(ROOT . '/views/layouts/_slider.php'); ?>
				<a class="link link_underline photo__link" href="">Выбрать из моб. галереи</a>
				<input class="button-2 button-2_inverse" type="button" value="Опубликовать">
			</div>
			<canvas id="canvas">
			</canvas>
			<div class="output">
				<img id="photo" alt="The screen capture will appear in this box.">
			</div>
		</div>
		<script src="/Camagru/public/js/main.js"></script>
		<script src="/Camagru/public/js/video.js"></script>
    	<script src="/Camagru/public/js/slider.js"></script>
	</body>
</html>
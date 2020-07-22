<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<header class="header {transparency}">
			<?php include(ROOT . "/views/layouts/_burger/_burger.php"); ?>
		</header>
		<div class="photo main-content">
			<div class="container container_medium photo__wrapper">
				<div class="photo__inner-wrapper">
					{errors}
					<div class="photo__container">
						<?php include(ROOT . '/views/layouts/_mask-control.php'); ?>
						<video class="photo__video" id="video">Video stream not available.</video>
						<button class="button-4 photo__button" type="button"  id="startbutton">
							<div class="photo__button-wrapper">
								<img class="button-4__img" src="/public/images/icons/camera_white.svg" alt="">
							</div>			
						</button>
					</div>
					<?php include(ROOT . '/views/layouts/_slider.php'); ?>
					<form class="photo__custom-input custom-input">
						<input class="custom-input__file" type="file" name="uploadfile" id="custom-file" accept=".jpg, .jpeg">
						<label class="custom-input__label" for="custom-file">
							<span class="custom-input__span">Выбрать файл&hellip;</span>
						</label>
					</form>
					<form class="photo__form" action="/photo/create" method="POST">
						<input class="photo__hidden" type="hidden" name="hidden">
						<input class="photo__hidden-info" type="hidden" name="info">
						<input class="button button_bg_pink photo__button-public" onclick="formMaskInformation()" type="button" value="Опубликовать" disabled>	
					</form>
					<canvas id="canvas" style="display: none">
					</canvas>
				</div>
				<div class="photo__grid">
					{lastPhotos}
				</div>
			</div>
		</div>
		<?php include(ROOT . "/views/layouts/_footer.php"); ?>
		<script src="/public/js/burger.js"></script>
		<script src="/public/js/main.js"></script>
		<script src="/public/js/video.js"></script>
		<script src="/public/js/slider.js"></script>
		<script src="/public/js/preview.js"></script>
	</body>
</html>
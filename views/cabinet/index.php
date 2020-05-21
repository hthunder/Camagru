<!DOCTYPE html>
<html lang="ru">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<div class="cabinet">
			<div class="top-line">	
			</div>
			<div class="container">
				<?php include(ROOT . '/views/layouts/_burger.php') ?>
				<img class="cabinet__avatar" src="/Camagru/public/images/avatar.jpg" alt="аватар">
				<form class="cabinet__form">
					<input class="cabinet__input cabinet__input-name" type="text"  value="София">
					<input class="cabinet__input cabinet__input-email" type="text"  value="sonya@gmail.com">
					<button class="cabinet__button" type="submit">Сохранить</button>
					<button class="cabinet__button cabinet__button-change" type="submit">Изменить</button>
					<div class="clearfix"></div>
				</form>
				<div class="cabinet__grid">
					<img class="cabinet__grid-item" src="/Camagru/public/images/kot-v-ochkah.jpg" alt="">
					<img class="cabinet__grid-item" src="/Camagru/public/images/kot-v-ochkah.jpg" alt="">
					<img class="cabinet__grid-item" src="/Camagru/public/images/kot-v-ochkah.jpg" alt="">
					<img class="cabinet__grid-item" src="/Camagru/public/images/kot-v-ochkah.jpg" alt="">
					<img class="cabinet__grid-item" src="/Camagru/public/images/kot-v-ochkah.jpg" alt="">
					<img class="cabinet__grid-item" src="/Camagru/public/images/kot-v-ochkah.jpg" alt="">
				</div>
				<input class="button-2 button-2_inverse cabinet__show-more" type="button" value="Показать больше">
			</div>
		</div>
	</body>
</html>
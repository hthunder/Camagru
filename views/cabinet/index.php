<!DOCTYPE html>
<html lang="ru">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<div class="cabinet">
			<div class="top-line">	
			</div>
			<div class="container">
				<?php include(ROOT . '/views/layouts/_burger.php') ?>
				<img class="cabinet__avatar" src="/public/images/avatars/{avatar_src}" alt="аватар">
				<div class="cabinet__form">
					<input class="cabinet__input cabinet__input_username" id="forhidden1" type="text" value="{username}">
					<input class="cabinet__input cabinet__input_email" id="forhidden2" type="text" value="{email}">
					<?php include(ROOT . '/views/layouts/_modal.php'); ?>
					<div class="clearfix"></div>	
				</div>
				<form class="cabinet__form cabinet__form_password" method="POST" action="/cabinet/changePass">
					<input class="cabinet__input" type="password" name="oldPass" placeholder="Ваш старый пароль">
					<input class="cabinet__input" type="password" name="pass1" placeholder="Новый пароль">
					<input class="cabinet__input" type="password" name="pass2" placeholder="Повторите новый пароль">
					<button class="cabinet__button" type="submit" name="changePass">Сохранить</button>
					<div class="clearfix"></div>
				</form>
				<p class="edit__errors">{errors}</p>
				<div class="cabinet__grid">
					<img class="cabinet__grid-item" src="/public/images/kot-v-ochkah.jpg" alt="">
					<img class="cabinet__grid-item" src="/public/images/kot-v-ochkah.jpg" alt="">
					<img class="cabinet__grid-item" src="/public/images/kot-v-ochkah.jpg" alt="">
					<img class="cabinet__grid-item" src="/public/images/kot-v-ochkah.jpg" alt="">
					<img class="cabinet__grid-item" src="/public/images/kot-v-ochkah.jpg" alt="">
					<img class="cabinet__grid-item" src="/public/images/kot-v-ochkah.jpg" alt="">
				</div>
				<input class="button button_bg_pink cabinet__show-more" type="button" value="Показать больше">
			</div>
		</div>
		<script src="/public/js/modal.js"></script>
	</body>
</html>
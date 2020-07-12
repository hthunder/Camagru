<!DOCTYPE html>
<html class="html" lang="en">
<?php include(ROOT . "/views/layouts/_head.php"); ?>
<body class="body body_back">
	<?php include(ROOT . "/views/layouts/_header/_header-unauthorized.php"); ?>
	<div class="index-container main-content">
		<div class="index-container__inner">
			{burger}
			<div class="index-container__entry">
				<div class="index-container__text-block">
					<!-- //TODO replace the logout icon and change it in code -->
					<!-- //TODO delete the notifications button and the logout button 
					from burger for not authorized users and delete the cabinet button. Add a link to go
					to the main page -->
					<img class="index-container__icon-img" src="/public/images/icons/camera_white.svg" alt="">
					<h1 class="index-container__heading">Camagru</h1>
					<p class="index-container__text">
						Место, где делятся миллионами эмоций
					</p>
				</div>
				<div class="index-container__buttons">
					<a href="/user/login" class="button button_bg_transparent button_link index-container__button">
						Войти
					</a>
					<a href="/user/register" class="button button_bg_white button_link index-container__button">
						Зарегистрироваться
					</a>
				</div>
			</div>
			<div class="index-container__img-wrapper">
				<img class="index-container__img" src="/public/images/index_page/telephones.png" alt="">
			</div>
		</div>
	</div>
	<?php include(ROOT . "/views/layouts/_footer-transparent.php"); ?>
</body>
</html>
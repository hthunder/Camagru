<!DOCTYPE html>
<html class="html" lang="en">
<?php include(ROOT . "/views/layouts/_head.php"); ?>
<body class="body body_back">
	<?php include(ROOT . "/views/layouts/_header-transparent.php"); ?>
	<div class="index-container main-content">
		<div class="index-container__inner">
			<?php include(ROOT . "/views/layouts/_burger.php"); ?>
			<div class="index-container__entry">
				<div class="index-container__text-block">
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
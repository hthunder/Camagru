<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body body_bg_accent">
		<header class="header {transparency}">
			<?php include(ROOT . "/views/layouts/_burger/_burger-unauth.php"); ?>
		</header>
		<div class="login main-content">
			<div class="container">
				<div class="logo login__logo">
					<img class="logo__img" src="/public/images/icons/camera_white.svg" alt="">
					<span class="logo__text">Camagru</span>
				</div>
				<form class="login__form" method="POST" action="/user/login">
					<input class="input-1 login__form-login" type="text" name="email_username" value="{email_username}" placeholder="Логин или эл. адрес">
					<input class="input-1 login__form-password" type="password" name="password" placeholder="Пароль">
					<p class="login__errors">{errors}</p>
					<a href="/user/forgotPass" class="link link_underline">
						Забыли пароль?	
					</a>
					<button class="button button_bg_transparent login__form-button" type="submit" name="login">
						Войти
					</button>
					<span class="login__text">
						У вас еще нет аккаунта?
					</span>
					<a class="link link_underline" href="/user/register">
						Зарегистрироваться!
					</a>
				</form>
			</div>	
		</div>
		<?php include(ROOT . "/views/layouts/_footer-transparent.php"); ?>
		<script src="/public/js/burger.js"></script>
	</body>
</html>
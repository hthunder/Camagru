<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body body_bg_accent">
		<div class="login">
				<div class="logo login__logo">
					<img class="logo__img" src="/Camagru/public/images/mdi-light_camera.png" alt="">
					<span class="logo__text">Camagru</span>
				</div>
				<form class="login__form" method="POST" action="/Camagru/user/login">
					<input class="input-1 login__form-login" type="text" name="email_username" placeholder="Логин или эл. адрес">
					<input class="input-1 login__form-password" type="password" name="password" placeholder="Пароль">
					<?php if(isset($error) && $error != false) {echo $error;} ?>
					<a href="#" class="link link_underline">
						Забыли пароль?	
					</a>
					<button class="button button_bg_transparent login__form-button" type="submit" name="login">
						Войти
					</button>
					<span class="login__text">
						У вас еще нет аккаунта?
					</span>
					<a class="link link_underline" href="/Camagru/user/register">
						Зарегистрироваться!
					</a>
				</form>
		</div>
	</body>
</html>
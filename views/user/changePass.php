<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body body_bg_accent">
		<div class="login">
				<div class="logo login__logo">
					<img class="logo__img" src="/public/images/mdi-light_camera.png" alt="">
					<span class="logo__text">Camagru</span>
				</div>
				<form class="login__form" method="POST" action="/user/changePass/{activationCode}">
					<input class="input-1 login__form-login" type="password" name="pass1" placeholder="Введите новый пароль">
					<input class="input-1 login__form-password" type="password" name="pass2" placeholder="Повторите пароль">
                    <p class="login__errors">{errors}</p>
					<button class="button button_bg_transparent login__form-button" type="submit" name="changePass">
						Изменить пароль
					</button>
				</form>
		</div>
	</body>
</html>
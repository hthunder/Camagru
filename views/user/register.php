<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body body_bg_accent">
		<a class="link back__link" href="/Camagru">
			Регистрация
		</a>
		<div class="vertical-aligner">
			<div class="register">
				<div class="logo login__logo">
						<img class="logo__img" src="/Camagru/public/images/mdi-light_camera.png" alt="">
						<span class="logo__text">Camagru</span>
				</div>
				<form class="register__form" action="/Camagru/user/register" method="POST">
					<input class="input-1 register__form-input" type="text" name="username" <?php if (isset($username) && $username) {echo("placeholder=$username");} else echo("placeholder='Логин'"); ?>>
					<input class="input-1 register__form-input" type="text" name="email" <?php if (isset($email) && $email) {echo("placeholder=$email");} else echo("placeholder='Электронный адрес'"); ?>>
					<input class="input-1 register__form-input" type="password" name="password" placeholder="Пароль">
					<input class="input-1 register__form-input" type="password" name="password" placeholder="Повторите пароль">
					<!-- <p class="register__errors">
						<?php if (isset($errors) && $errors != false) var_dump($errors); ?>
					</p> -->
					<button class="button-2 register__form-button" type="submit" name="signup">
						Зарегистрироваться
					</button>
				</form>
			</div>
		</div>
	</body>
</html>
<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body body_bg_accent">
		<a class="link back__link" href="">
			Регистрация
		</a>
		<div class="vertical-aligner">
			<div class="register">
				<div class="logo login__logo">
						<img class="logo__img" src="/public/images/mdi-light_camera.png" alt="">
						<span class="logo__text">Camagru</span>
				</div>
				<form class="register__form" action="/user/register" method="POST">
					<input class="input-1 register__form-input" required type="text" name="username" <?php if (isset($username) && $username) {echo("placeholder=$username");} else echo("placeholder='Логин'"); ?>>
					<input class="input-1 register__form-input" required type="text" name="email" <?php if (isset($email) && $email) {echo("placeholder=$email");} else echo("placeholder='Электронный адрес'"); ?>>
					<input class="input-1 register__form-input" required type="password" name="pass1" placeholder="Пароль">
					<input class="input-1 register__form-input" required type="password" name="pass2" placeholder="Повторите пароль">
					<!-- <p class="register__errors">
						<?php if (isset($errors) && $errors != false) var_dump($errors); ?>
					</p> -->
					<button class="button button_bg_transparent register__form-button" type="submit" name="signup">
						Зарегистрироваться
					</button>
				</form>
			</div>
		</div>
	</body>
</html>
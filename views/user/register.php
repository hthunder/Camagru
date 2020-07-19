<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body body_bg_accent">
		<header class="header {transparency}">
			<?php include(ROOT . "/views/layouts/_burger/_burger-unauth.php"); ?>
		</header>
		<div class="container register main-content">
			<div class="logo register__logo">
					<img class="logo__img" src="/public/images/icons/camera_white.svg" alt="">
					<span class="logo__text">Camagru</span>
			</div>
			<form class="register__form" action="/user/register" method="POST">
				<input class="input-1 register__form-input" type="text" name="username" value="{username}" placeholder="Логин" required>
				<input class="input-1 register__form-input" type="text" name="email" value="{email}" placeholder="Электронный адрес" required>
				<input class="input-1 register__form-input" required type="password" name="pass1" placeholder="Пароль">
				<input class="input-1 register__form-input" required type="password" name="pass2" placeholder="Повторите пароль">
				<p class="register__errors">{errors}</p>
				<button class="button button_bg_transparent register__form-button" type="submit" name="signup">
					Зарегистрироваться
				</button>
			</form>
		</div>
		<?php include(ROOT . "/views/layouts/_footer-transparent.php"); ?>
		<script src="/public/js/app.js"></script>
	</body>
</html>
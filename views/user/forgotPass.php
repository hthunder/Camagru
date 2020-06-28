<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body body_bg_accent">
        <a class="link back__link" href="/user/login">
            Вернуться назад
        </a>
		<div class="login">
            <div class="logo login__logo">
                <img class="logo__img" src="/public/images/mdi-light_camera.png" alt="">
                <span class="logo__text">Camagru</span>
            </div>
            <form class="login__form" method="POST" action="/user/forgotPass">
                <input class="input-1 login__form-login" type="text" name="email" value="{email}" placeholder="Электронный адрес">
                <p class="login__errors">{errors}</p>
                <button class="button button_bg_transparent login__form-button" type="submit" name="forgotPass">
                    Восстановить пароль
                </button>
            </form>
		</div>
	</body>
</html>
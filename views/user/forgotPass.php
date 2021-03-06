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
                <form class="login__form" method="POST" action="/user/forgotPass">
                    <input class="input-1 login__form-login" type="text" name="email" value="{email}" placeholder="Электронный адрес">
                    <p class="login__errors">{errors}</p>
                    <button class="button button_bg_transparent login__form-button" type="submit" name="forgotPass">
                        Восстановить пароль
                    </button>
                </form>
            </div>
        </div>
        <?php include(ROOT . "/views/layouts/_footer-transparent.php"); ?>
        <script src="/public/js/burger.js"></script>
	</body>
</html>
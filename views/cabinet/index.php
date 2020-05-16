<!DOCTYPE html>
<html lang="ru">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<div class="cabinet">
			<div class="burger">
				<input type="checkbox" id="burger" class="burger__hidden-checkbox">
				<label class="burger__btn" for="burger">
					<span class="burger__bar burger__bar_mt_0"></span>
					<span class="burger__bar"></span>
					<span class="burger__bar"></span>
				</label>
				<ul class="burger__hidden-list">
					<li class="burger__list-item">
						<a class="link burger__list-link" href="">
							Галерея<img class="burger__icon" src="/Camagru/public/images/icons/picture.svg" alt="">
						</a>
					</li>  
					<li class="burger__list-item">
						<a class="link burger__list-link" href="">
							Сделать фото<img class="burger__icon" src="/Camagru/public/images/icons/camera.svg" alt="">
						</a>
					</li>
					<li class="burget__list-item">
						<label class="checkbox">
							<span class="link burger__list-link">Уведомления</span>
							<input class="checkbox__input" type="checkbox">
							<div class="checkbox__custom-element"></div>
						</label>
					</li>
					<li class="burger__list-item">
						<a class="link burger__list-link" href="">
							Личный кабинет<img class="burger__icon" src="/Camagru/public/images/icons/avatar.svg" alt="">
						</a>
					</li>
					<li class="burger__list-item">
						<a class="link burger__list-link" href="">
							Сменить пароль<img class="burger__icon" src="/Camagru/public/images/icons/key.svg" alt="">
						</a>
					</li> 
					<li class="burger__list-item">
						<button type="submit" class="link burger__list-link burger__list-link_button" href="">
							Выйти<span class="close"></span>
						</button>
					</li> 
				</ul>
			</div>
			<!-- <div style="height: 100px;">

			</div>
			<label class="checkbox">
				<a href="" class="link burger__list-link">Уведомления</a>
				<input class="checkbox__input" type="checkbox">
				<div class="checkbox__custom-element"></div>
			</label> -->
		</div>
		
			<!-- <section class="cabinet">
				<div class="container">
					<form class="cabinet__logout" action="core/logout.php" method="POST">
						<h1 class="title-1">Кабинет пользователя</h1>
						<button class="button button_accent" type="submit" name="logout">Выйти</button>
					</form>
					<form class="cabinet__form" action="core/update.php" method="POST">
						<fieldset class="cabinet__fieldset">
							<label class="cabinet__label cabinet__input">Имя пользователя<input class="input cabinet__input" placeholder="" name="name" type="text" ></label>
						</fieldset>
						<fieldset class="cabinet__fieldset">
							<legend class="cabinet__legend">Изменение пароля</legend>
							<label class="cabinet__label">Старый пароль<input class="input cabinet__input" name="old-pass" type="password"></label>
							<label class="cabinet__label">Введите новый пароль<input class="input cabinet__input" name="new-pass1" type="password"></label>
							<label class="cabinet__label">Повторите новый пароль<input class="input cabinet__input" name="new-pass2" type="password"></label>
						</fieldset>
						<fieldset class="cabinet__fieldset">
							<legend class="cabinet__legend">О себе</legend>
							<label class="cabinet__label">Дата рождения<input class="input cabinet__input" value="" name="birthday" type="date"></label>
							<p class="cabinet__text-sex">Ваш пол:</p>
						</fieldset>
						<button class="button" type="submit" name="update">Обновить</button>
					</form>
				</div>
			</section> -->
	</body>
</html>
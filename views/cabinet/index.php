<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<div class="cabinet main-content">
			<header class="header {transparency}">
				<?php include(ROOT . "/views/layouts/_burger/_burger.php"); ?>
			</header>
			<div class="container">
				<div class="cabinet__wrapper">
					<div class="cabinet__userinfo">
						<img class="cabinet__avatar" src="/public/images/avatars/{avatar_src}" alt="аватар">
						
						<form class="cabinet__avatar-form" method="POST" action="/cabinet/uploadAvatar" enctype="multipart/form-data">
							<div>
								<span class="cabinet__avatar-message">Загрузить аватар:</span>
								<input type="file" name="uploadedFile" accept=".jpg, .jpeg">
							</div>
							<input type="submit" name="uploadBtn" value="Загрузить">
						</form>
						
						<div class="cabinet__form">
							<input class="cabinet__input cabinet__input_username" id="forhidden1" type="text" value="{username}">
							<input class="cabinet__input cabinet__input_email" id="forhidden2" type="text" value="{email}">
							<?php include(ROOT . '/views/layouts/_modal.php'); ?>
							<div class="clearfix"></div>	
						</div>
						<form class="cabinet__form cabinet__form_password" method="POST" action="/cabinet/changePass">
							<input class="cabinet__input" type="password" name="oldPass" placeholder="Ваш старый пароль" required>
							<input class="cabinet__input" type="password" name="pass1" placeholder="Новый пароль" required>
							<input class="cabinet__input" type="password" name="pass2" placeholder="Повторите новый пароль" required>
							<button class="cabinet__button" type="submit" name="changePass">Сохранить</button>
							<div class="clearfix"></div>
						</form>
						<div class="cabinet__form cabinet__form_notifications">
							<input class="checkbox__input" type="checkbox" id="checkbox1" {checked}>
							<label class="checkbox__custom-element cabinet__checkbox" for="checkbox1">Уведомления</label>
						</div>
						<p class="cabinet__errors">{errors}</p>
					</div>
					<div class="cabinet__grid">
						{cabinet__grid}
						<input class="button button_bg_pink cabinet__show-more" type="button" value="Показать больше" data-id="{min_id}"> 
					</div>
				</div>
			</div>
		</div>
		<?php include(ROOT . "/views/layouts/_footer.php"); ?>
		<script src="/public/js/burger.js"></script>
		<script src="/public/js/modal.js"></script>
		<script src="/public/js/ajax.js"></script>
		<script src="/public/js/notifications.js"></script>
		<script src="/public/js/show-more.js"></script>
	</body>
	
</html>
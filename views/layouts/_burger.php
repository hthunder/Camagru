<div class="burger">
	<input type="checkbox" id="burger" class="burger__hidden-checkbox">
	<label class="burger__btn" for="burger">
		<span class="burger__bar burger__bar_mt_0"></span>
		<span class="burger__bar"></span>
		<span class="burger__bar"></span>
	</label>
	<ul class="burger__hidden-list">
		<li class="burger__list-item">
			<a class="link burger__list-link" href="/photo/gallery">
				Галерея<img class="burger__icon" src="/public/images/icons/picture.svg" alt="Галерея">
			</a>
		</li>  
		<li class="burger__list-item">
			<a class="link burger__list-link" href="/photo/make">
				Сделать фото<img class="burger__icon" src="/public/images/icons/camera.svg" alt="Сделать фото">
			</a>
		</li>
		<li class="burger__list-item">
			<input class="checkbox__input" type="checkbox"  id="checkbox">
			<label class="link burger__list-link checkbox__custom-element" for="checkbox">Уведомления</label>
		</li>
		<li class="burger__list-item">
			<a class="link burger__list-link" href=/cabinet>
				Личный кабинет<img class="burger__icon" src="/public/images/icons/avatar.svg" alt="Личный кабинет">
			</a>
		</li>
		<li class="burger__list-item">
			<a class="link burger__list-link" href="#">
				Сменить пароль<img class="burger__icon" src="/public/images/icons/key.svg" alt="Сменить пароль">
			</a>
		</li> 
		<li class="burger__list-item burger__list-item_bottom">
			<form action="/user/logout" method="POST">
				<button type="submit" name="logout" class="link burger__list-link burger__list-link_button">
					Выйти<span class="close"></span>
				</button>
			</form>
			
		</li> 
	</ul>
</div>
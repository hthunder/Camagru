<header class="header">
	<div class="container container_justify-content_center">
		<div class="header__logo">
			<a class="link header__logo-link " href="index.php">Camagru</a>
			<a class="header__logo-link" href="">
				<img class="header__logout-img" src="/Camagru/public/images/photo-camera.svg" alt="">
			</a>
		</div>
		<nav class="nav header__nav">
			<ul class="nav__list">
				<li class="nav__item"><a class="link nav__link" href="index.php">Галерея</a></li>
				<li class="nav__item"><a class="link nav__link" href="products.php">Сфотографироваться</a></li>
				<?php if (isset($userId) && $userId != "") { ?>
					<li class="nav__item"><a class="link nav__link" href="cabinet.php" >Кабинет</a></li>
					<form class="header__logout-form" method="POST" action="core/logout.php">
						<button class="header__logout-link"  type="submit" name="logout">
							<img class="header__logout-img" src="public/images/logout.svg" alt="Выход">
						</button>
					</form>
				<?php } else { ?>
					<li class="nav__item"><a class="link nav__link" href="">Войти</a></li>
				<?php } ?>
			</ul>
		</nav>
	</div>
</header>

<!-- <?php if (isset($_SESSION["is_auth"]) && $_SESSION["is_auth"] == true) { ?> <?php } ?> -->
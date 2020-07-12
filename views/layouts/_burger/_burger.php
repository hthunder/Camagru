<div class="burger">
	<input type="checkbox" id="burger" class="burger__hidden-checkbox">
	<label class="burger__btn" for="burger">
		<span class="burger__bar burger__bar_mt_0"></span>
		<span class="burger__bar"></span>
		<span class="burger__bar"></span>
	</label>
	<ul class="burger__hidden-list">
		<?php include(ROOT . "/views/layouts/_burger/_gallery.php") ?>
		<?php include(ROOT . "/views/layouts/_burger/_make-photo.php") ?>
		<?php include(ROOT . "/views/layouts/_burger/_notifications.php") ?>
		<?php include(ROOT . "/views/layouts/_burger/_cabinet.php") ?>
		<?php include(ROOT . "/views/layouts/_burger/_logout.php") ?>
	</ul>
</div>
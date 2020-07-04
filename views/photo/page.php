<!DOCTYPE html>
<html lang="ru">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<article class="page">
			<div class="top-line">
			</div>
			<div class="container container_small">
				<?php include(ROOT . '/views/layouts/_burger.php'); ?>
				<div class="page__wrapper">
					<div class="page__photo-wrapper">
						<img class="page__photo" src="/public/images/gallery/{hostId}/{name}.jpg">
						<div class="page__bottom-wrapper">
							<span class="page__likes">
								{likeIcon}
								<strong class="page__likes-number">{likesNumber}</strong>
							</span>
							<form class="page__delete-form" action="/photo/delete" method="POST">
								<input type="hidden" name="photoId" value="{photoId}">
								<button class="page__delete-button" type="sumbit" name="delete">
									<img class="page__delete-icon" src="/public/images/icons/bin.svg" alt="Удалить комментарий">
								</button>
							</form>	
						</div>
					</div>
					<section class="page__commentaries commentaries">
						<h2 class="commentaries__heading">Комментарии</h2>
						<form class="commentaries__form" action="/comment/add" method="POST">
							<input class="commentaries__form-text" type="text" maxlength="50" name="comment" placeholder="Написать комментарий" required>
							<input class="commentaries__form-hidden" type="hidden" name="photo_name" value="{name}">
							<input class="commentaries__form-hidden" type="hidden" name="photoOwner" value="{hostId}">
							<input class="commentaries__form-submit" type="submit" value="Отправить">
						</form>
						{comments}
						{showMore}
					</section>
				</div>
			</div>
		</article>
		<script src="/public/js/photo-delete.js"></script>
		<script src='/public/js/ajax.js'></script>
		<script src='/public/js/like.js'></script>
		<script src='/public/js/show-more-comments.js'></script>
	</body>
</html>
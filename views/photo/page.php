<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<article class="page">
			<div class="top-line">
			</div>
			<div class="container container_small">
				<?php include(ROOT . '/views/layouts/_burger.php'); ?>
				<div class="page__wrapper">
					<div class="page__photo-wrapper">
						<img class="page__photo" src="/public/images/gallery/{hostId}/{fullName}">
						<div class="page__bottom-wrapper">
							<span class="page__likes">
								{likeIcon}
								<strong class="page__likes-number">{likesNumber}</strong>
							</span>
							{deletePhoto}
						</div>
					</div>
					<section class="page__commentaries commentaries">
						<h2 class="commentaries__heading">Комментарии</h2>
						<form class="commentaries__form" action="/comment/add" method="POST">
							<input class="commentaries__form-text" type="text" maxlength="45" name="comment" placeholder="Написать комментарий" required>
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
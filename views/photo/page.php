<!DOCTYPE html>
<html lang="en">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<article class="page main-content">
			<div class="top-line">
			</div>
			<?php include(ROOT . "/views/layouts/_header/_header.php"); ?>
			<div class="container container_small">
				<?php include(ROOT . '/views/layouts/_burger/_burger.php'); ?>
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
							<button class="commentaries__form-submit" type="submit" data-photo-owner="{hostId}" data-photo-name="{name}" data-guest-name="{guestName}">Отправить</button>
						</form>
						{comments}
						{showMore}
					</section>
				</div>
			</div>
		</article>
		<?php include(ROOT . "/views/layouts/_footer.php"); ?>
		<script src="/public/js/photo-delete.js"></script>
		<script src='/public/js/ajax.js'></script>
		<script src="/public/js/ajax-form-data.js"></script>
		<script src='/public/js/like.js'></script>
		<script src='/public/js/show-more-comments.js'></script>
		<script src="/public/js/comment-delete.js"></script>
		<script src="/public/js/comment-add.js"></script>
	</body>
</html>
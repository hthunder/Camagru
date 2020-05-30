<!DOCTYPE html>
<html lang="ru">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<article class="page">
			<div class="top-line">	
			</div>
			<div class="container">
				<?php include(ROOT . '/views/layouts/_burger.php'); ?>
				<div class="page__wrapper">
					<div class="page__photo-wrapper">
						<img class="page__photo" src="/Camagru/public/images/gallery/<?php echo($photoOwnerId . '/' . $name . '.jpg'); ?>">
						<span class="page__likes">
							<?php if($isLiked != null && $isLiked == 1) {?>
							<img class="page__likes-icon" src="/Camagru/public/images/icons/likePushed.svg" alt="лайк" data-photo-name="<?php echo($name); ?>">
							<?php } else { ?>
							<img class="page__likes-icon" src="/Camagru/public/images/icons/like.svg" alt="лайк" data-photo-name="<?php echo($name); ?>">
							<?php } ?>
							<strong class="page__likes-number"><?php echo($likesNumber); ?></strong>
						</span>	
					</div>
					
					<section class="page__commentaries commentaries">
						<h2 class="commentaries__heading">Комментарии</h2>
						<form class="commentaries__form" action="/Camagru/comment/add" method="POST">
							<input class="commentaries__form-text" type="text" maxlength="50" name="comment" placeholder="Написать комментарий" required>
							<input class="commentaries__form-hidden" type="hidden" name="photo_name" value="<?php echo($name); ?>">
							<input class="commentaries__form-hidden" type="hidden" name="photoOwner" value="<?php echo($photoOwnerId); ?>">
							<input class="commentaries__form-submit" type="submit" value="Отправить">
						</form>
						<?php
							$counter = 0;
							foreach($comments as $comment) {
								if ($counter < 5) {
						?>
						<article class="commentary">
							<p class="commentary__text">
								<span class="commentary__author"><?php echo($comment["username"]); ?>:</span>
								<?php echo($comment["text"]); ?>
							</p>
						</article>
						<?php 	} else { ?>
						<article class="commentary commentary_hidden">
							<p class="commentary__text">
								<span class="commentary__author"><?php echo($comment["username"]); ?>:</span>
								<?php echo($comment["text"]); ?>
							</p>
						</article>
						<?php
								}
								$counter++; 
							}
							?>
						<?php if ($counter > 5) { ?>
							<input class="commentaries__show-more" type="button" value="Показать больше" onclick="showMoreComments();">
						<?php } ?>
					</section>
				</div>
			</div>
		</article>
		<script src='/Camagru/public/js/ajax.js'></script>
		<script src='/Camagru/public/js/like.js'></script>
		<script src='/Camagru/public/js/show-more-comments.js'></script>
	</body>
</html>
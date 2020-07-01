<!DOCTYPE html>
<html lang="ru">
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<div class="gallery">
			<div class="top-line">	
			</div>
			<div class="container">
				<?php include(ROOT . '/views/layouts/_burger.php'); ?>
				<div class="gallery__grid masonry">
					{gallery__grid}	
				</div>
				<input class="button button_bg_pink gallery__show-more" type="button" value="Показать больше" data-id="{min_id}">
			</div>
		</div>
		<script src="/public/js/ajax.js"></script>
		<script src='/public/js/show-more.js'></script>
	</body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .masonry { 
            display: flex;
            flex-flow: row wrap;
            margin-left: -8px; /* Adjustment for the gutter */
            width: 100%;
        }

        .masonry-brick {
            flex: auto;
            height: 250px;
            min-width: 150px;
            margin: 0 8px 8px 0; /* Some gutter */
        }
        .masonry-img {
    object-fit: cover;
    width: 100%;
    height: 100%;
    filter: brightness(50%);
}
img {
    vertical-align: middle;
    max-width: 100%;
}
        .masonry-brick:nth-child(4n+1) {
        width: 250px;
        }
        .masonry-brick:nth-child(4n+2) {
        width: 325px;
        }
        .masonry-brick:nth-child(4n+3) {
        width: 180px;
        }
        .masonry-brick:nth-child(4n+4) {
        width: 380px;
        }
    </style>
</head>
<body>
    <div class="masonry masonry--h">
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/400?image=1" class="masonry-img" alt="Masonry Brick #1"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/300?image=2" class="masonry-img" alt="Masonry Brick #2"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/500?image=3" class="masonry-img" alt="Masonry Brick #3"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/250?image=4" class="masonry-img" alt="Masonry Brick #4"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/450?image=5" class="masonry-img" alt="Masonry Brick #5"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/350?image=6" class="masonry-img" alt="Masonry Brick #6"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/600?image=18" class="masonry-img" alt="Masonry Brick #7"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/700?image=8" class="masonry-img" alt="Masonry Brick #8"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/200?image=19" class="masonry-img" alt="Masonry Brick #9"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/300?image=10" class="masonry-img" alt="Masonry Brick #10"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/420?image=11" class="masonry-img" alt="Masonry Brick #11"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/450?image=12" class="masonry-img" alt="Masonry Brick #12"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/550?image=13" class="masonry-img" alt="Masonry Brick #13"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/640?image=14" class="masonry-img" alt="Masonry Brick #14"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/420?image=15" class="masonry-img" alt="Masonry Brick #15"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/430?image=16" class="masonry-img" alt="Masonry Brick #16"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/340?image=17" class="masonry-img" alt="Masonry Brick #17"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/240?image=27" class="masonry-img" alt="Masonry Brick #18"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/780?image=19" class="masonry-img" alt="Masonry Brick #19"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/470?image=20" class="masonry-img" alt="Masonry Brick #20"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/380?image=21" class="masonry-img" alt="Masonry Brick #21"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/240?image=22" class="masonry-img" alt="Masonry Brick #22"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/900?image=23" class="masonry-img" alt="Masonry Brick #23"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/480?image=24" class="masonry-img" alt="Masonry Brick #24"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/300?image=25" class="masonry-img" alt="Masonry Brick #25"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/400?image=26" class="masonry-img" alt="Masonry Brick #26"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/500?image=27" class="masonry-img" alt="Masonry Brick #27"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/520?image=28" class="masonry-img" alt="Masonry Brick #28"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/920?image=29" class="masonry-img" alt="Masonry Brick #29"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/400?image=30" class="masonry-img" alt="Masonry Brick #30"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/560?image=31" class="masonry-img" alt="Masonry Brick #31"></figure>
        <figure class="masonry-brick masonry-brick--h"><img src="https://unsplash.it/700/370?image=32" class="masonry-img" alt="Masonry Brick #32"></figure>
      </div>
</body>
</html> -->
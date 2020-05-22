<div class="photo__slider-container">
	<a class="slider__control slider__control_left" href="#" role="button"></a>
	<div class="slider">
		<div class="slider__wrapper">
			<?php foreach($masks as $mask) {
				if(!($mask == '.' || $mask == '..')) {	
			?>
				<div class="slider__item">
					<div class="photo__mask" data-current="false">
						<img class="photo__mask-img" src="/Camagru/public/images/masks/<?php echo($mask) ?>" alt="">
					</div>
				</div>
			<?php }} ?>
		</div>
	</div>
	<a class="slider__control slider__control_right slider__control_show" href="#" role="button"></a>
</div>

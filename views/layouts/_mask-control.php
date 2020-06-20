<button class="photo__exit-button" onclick="deletePhoto()">
	<div class="photo__button-wrapper">
		<img class="photo__exit-img" src="/public/images/icons/cross.svg" alt="">
	</div>
</button>	
<div class="photo__nav-container">
	<button class="photo__nav-button photo__nav-button_up" onclick="handleMask('top', '-')">
		<div class="photo__button-wrapper">
			<img class="photo__nav-img photo__nav-img_rot-90" src="/public/images/icons/pointer.svg" alt="">		
		</div>
	</button>
	<div class="photo__nav-center" >
		<button class="photo__nav-button photo__nav-button_left" onclick="handleMask('left', '-')">
			<div class="photo__button-wrapper">	
				<img class="photo__nav-img" src="/public/images/icons/pointer.svg" alt="">	
			</div>
		</button>
		<button class="photo__nav-button photo__nav-button_right" onclick="handleMask('left', '+')">
			<div class="photo__button-wrapper">
				<img class="photo__nav-img photo__nav-img_rot-180" src="/public/images/icons/pointer.svg" alt="">	
			</div>
		</button>	
	</div>
	<button class="photo__nav-button photo__nav-button_down" onclick="handleMask('top', '+')">
		<div class="photo__button-wrapper">
			<img class="photo__nav-img photo__nav-img_rot-270" src="/public/images/icons/pointer.svg" alt="">		
		</div>
	</button>
</div>
<div class="photo__scale-container">
	<button class="photo__scale-button photo__scale_up" onclick="handleMask('width', '+')">
		<div class="photo__button-wrapper">
			<img class="photo__scale-img" src="/public/images/icons/plus.svg" alt="">
		</div>
	</button>
	<button class="photo__scale-button photo__scale_down" onclick="handleMask('width', '-')">
		<div class="photo__button-wrapper">
			<img class="photo__scale-img" src="/public/images/icons/minus.svg" alt="">
		</div>
	</button>
</div>
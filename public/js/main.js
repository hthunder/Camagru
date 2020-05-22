function setListeners() {
	let sliderItems = document.querySelectorAll('.photo__mask');
	let navUpButton = document.querySelector('.photo__nav-button_up');
	let navLeftButton = document.querySelector('.photo__nav-button_left');
	let navRightButton = document.querySelector('.photo__nav-button_right');
	let navDownButton = document.querySelector('.photo__nav-button_down'); 
	let scaleUpButton = document.querySelector('.photo__scale_up'); 
	let scaleDownButton = document.querySelector('.photo__scale_down'); 
	sliderItems.forEach(function(item){
		item.addEventListener("click", toggleMask);
	})
	navUpButton.addEventListener("click", getUpMask);
	navLeftButton.addEventListener("click", getLeftMask);
	navRightButton.addEventListener("click", getRightMask);
	navDownButton.addEventListener("click", getDownMask);
	scaleUpButton.addEventListener("click", scaleUpMask);
	scaleDownButton.addEventListener("click", scaleDownMask);
}

function toggleMask() {
	let sliderItems = document.querySelectorAll('.photo__mask');
	if (this.classList.contains("photo__mask_active")) {
		sliderItems.forEach(function(item){
			if(item.classList.contains("photo__mask_active")) {
				item.classList.remove("photo__mask_active");
			}
		});
		this.classList.remove("photo__mask_active");
		let forRemove = document.querySelector('.photo__container .photo__mask-img');
		if (forRemove) {
			forRemove.parentNode.removeChild(forRemove);
		}
	} else {
		sliderItems.forEach(function(item){
			if(item.classList.contains("photo__mask_active")) {
				item.classList.remove("photo__mask_active");
			}
		});
		this.classList.add("photo__mask_active");
		drawMask(this);
	}
}

function drawMask(element) {
	let forRemove = document.querySelector('.photo__container .photo__mask-img');
	if (forRemove) {
		forRemove.parentNode.removeChild(forRemove);
	}
	let img = element.children[0];
	let copyimg = img.cloneNode(false);

	copyimg.style.position = "absolute";
	copyimg.style.width = "20%";
	copyimg.style.height = "auto";
	copyimg.style.top = "0%";
	copyimg.style.left = "50%";
	copyimg.style.transform = "translateX(-50%)";

	let video = document.querySelector('.photo__container');
	video.appendChild(copyimg);
}

function getUpMask() {
	let mask = document.querySelector(".photo__container .photo__mask-img");
	let value;
	if (mask) {
		value = +mask.style.top.split('%')[0];
		mask.style.top = (value - 1) + '%';
	}
}

function getLeftMask() {
	let mask = document.querySelector(".photo__container .photo__mask-img");
	let value;
	if (mask) {
		value = +mask.style.left.split('%')[0];
		mask.style.left = (value - 1) + '%';
	}
}

function getRightMask() {
	let mask = document.querySelector(".photo__container .photo__mask-img");
	let value;
	if (mask) {
		value = +mask.style.left.split('%')[0];
		mask.style.left = (value + 1) + '%';
	}
}

function getDownMask() {
	let mask = document.querySelector(".photo__container .photo__mask-img");
	let value;
	if (mask) {
		value = +mask.style.top.split('%')[0];
		mask.style.top = (value + 1) + '%';
	}
}

function scaleUpMask() {
	let mask = document.querySelector(".photo__container .photo__mask-img");
	let value;
	if (mask) {
		value = +mask.style.width.split('%')[0];
		mask.style.width = (value + 1) + '%';
	}
}

function scaleDownMask() {
	let mask = document.querySelector(".photo__container .photo__mask-img");
	let value;
	if (mask) {
		value = +mask.style.width.split('%')[0];
		mask.style.width = (value - 1) + '%';
	}
}

setListeners();
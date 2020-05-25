function setListeners() {
	let sliderItems = document.querySelectorAll('.photo__mask');
	sliderItems.forEach(function(item){
		item.addEventListener("click", toggleMask);
	})
}

function toggleMask() {
	let sliderItems = document.querySelectorAll('.photo__mask');
	if (this.classList.contains("photo__mask_active")) {
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
	let img = element.children[0];
	let copyimg = img.cloneNode(false);
	let video = document.querySelector('.photo__container');

	if (forRemove) {
		forRemove.parentNode.removeChild(forRemove);
	}
	copyimg.classList.add('photo__copy-img');
	copyimg.style.top = "0%";
	copyimg.style.left = "50%";
	copyimg.style.width = "20%";
	video.insertBefore(copyimg, video.firstChild);
}

function handleMask(property, sign) {
	let mask = document.querySelector(".photo__container .photo__mask-img");
	let value;
	if (mask) {
		value = +mask.style[property].split('%')[0];
		if (sign == '-')
			mask.style[property] = (value - 1) + '%';
		else
			mask.style[property] = (value + 1) + '%';
	}
}

setListeners();
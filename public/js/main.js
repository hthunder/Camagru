let labelVal = document.querySelector('.custom-input__label').innerHTML;

function setListeners() {
	let sliderItems = document.querySelectorAll('.photo__mask');
	sliderItems.forEach(function(item){
		item.addEventListener("click", toggleMask);
	})
}

function toggleMask() {
	if (this.classList.contains("photo__mask_active")) {
		this.classList.remove("photo__mask_active");
	} else {
		this.classList.add("photo__mask_active");
		drawMask(this);
	}
}



function drawMask(element) {
	let img = element.children[0];
	let copyimg = img.cloneNode(false);
	let video = document.querySelector('.photo__container');

	copyimg.classList.add('photo__copy-img');
	copyimg.style.top = "0%";
	copyimg.style.left = "50%";
	copyimg.style.width = "20%";
	let insertedNode = video.insertBefore(copyimg, video.firstChild);
	element.addEventListener("click", function deleteMaskFromWindow(evt) {
		insertedNode.remove();
		element.removeEventListener("click", deleteMaskFromWindow);
	})
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

function deletePhoto() {
	document.querySelector(".photo__output").remove();
	document.querySelector(".photo__video").style.display = "";
	document.querySelector('.photo__exit-button').style.display = 'none';
	document.querySelector('.photo__button').style.display = 'block';
	document.querySelector('.custom-input__label').innerHTML = labelVal;
	document.querySelector('.custom-input__file').value = '';
	document.querySelector('.photo__container').style.minHeight = '196px';
	document.querySelector('.photo__button-public').disabled = true;
	let copyImg = document.querySelector('.photo__copy-img');
	if (copyImg)
		copyImg.remove();
	let sliderMasks = document.querySelectorAll('.photo__mask');
	sliderMasks.forEach(function (mask) {
		if (mask.classList.contains('photo__mask_active')) {
			mask.classList.remove('photo__mask_active');
		}
	});
}

setListeners();
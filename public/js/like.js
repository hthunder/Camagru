document.querySelector('.page__likes-icon').addEventListener('click', like);

function like(event) {
	const regex = RegExp('like.svg');
	let temp = document.querySelector('.page__likes-number').innerText;
	if (regex.test(event.target.src)) {
		event.target.src = '/public/images/icons/likePushed.svg';
		document.querySelector('.page__likes-number').innerText = +temp + 1;
		ajax('/like/addRemove', 'POST', null, {
			like: "true",
			photoId: event.target.dataset.photoId,
		})
	}	
	else {
		event.target.src = '/public/images/icons/like.svg';
		let newTemp = +temp - 1;
		if (newTemp >= 0) {
			document.querySelector('.page__likes-number').innerText = newTemp;
			ajax('/like/addRemove', 'POST', null, {
				like: "false",
				photoId: event.target.dataset.photoId,
			})	
		}
	}	
}

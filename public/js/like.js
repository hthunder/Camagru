document.querySelector('.page__likes-icon').addEventListener('click', like);

function like(event) {
	const regex = RegExp('like.svg');
	let temp = document.querySelector('.page__likes-number').innerText;
	if (regex.test(event.target.src)) {
		event.target.src = '/public/images/icons/likePushed.svg';
		document.querySelector('.page__likes-number').innerText = +temp + 1;
		ajax('/like/addRemove', 'POST', null, {
			like: 'true',
			photoName: event.target.dataset.photoName,
		})
	}	
	else {
		event.target.src = '/public/images/icons/like.svg';
		document.querySelector('.page__likes-number').innerText = +temp - 1;
		ajax('/like/addRemove', 'POST', null, {
			like: 'false',
			photoName: event.target.dataset.photoName,
		})
	}	
}

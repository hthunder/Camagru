function showMore(srcs) {
	let grid = document.querySelector('.cabinet__grid');
	let counter = 0;
	srcs.forEach(element => {
		counter++;
		let img = document.createElement('img');
		let link = document.createElement('a');
		if (element != null) {
			img.src = '/public/images/gallery/' + element['user_id'] + '/' + element['photo_src'];
			img.classList.add('cabinet__grid-item');
			link.classList.add('cabinet__grid-link');
			link.href = "/photo/page/" + element["user_id"] + "/" + element["photo_src"];
			link.href = (link.href.replace(/.jpe?g$/, ""));
			// grid.appendChild(link);
			link.appendChild(img);
			grid.insertBefore(link, button);
			// parentElement.insertBefore(newElement, referenceElement)
			if (+element['id'] < +button.dataset.id)
				button.dataset.id = element['id'];
		}
	});
	if (counter < 6)
		button.disabled = true;
}
let button = document.querySelector('.cabinet__show-more');
if (button){
	button.onclick = function(){
		let dataId = button.dataset.id;
		if (dataId) {
			let id = {id: dataId};
			ajax('/photo/showMore', 'POST', showMore, id);
		} else {
			button.disabled = true;
		}
		
	};	
}

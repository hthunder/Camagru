function showMore(srcs) {
	let grid = document.querySelector('.gallery__grid');
	let counter = 0;
	let showMore = document.querySelector('.gallery__show-more');
	srcs.forEach(element => {
		counter++;
		showMore = document.querySelector('.gallery__show-more');
		let img = document.createElement('img');
		let link = document.createElement('a');
		if (element != null) {
			img.src = '/public/images/gallery/';
			img.src += element['user_id'];
			img.src += '/';
			img.src += element['photo_src'];
			img.classList.add('gallery__grid-item');
			link.classList.add('gallery__grid-link');
			link.href = "/photo/page/" + element["user_id"] + "/" + element["photo_src"];
			link.href = (link.href.replace(/.jpe?g$/, ""));
			grid.appendChild(link);
			link.appendChild(img);
			if (+element['id'] < +showMore.dataset.id)
				showMore.dataset.id = element['id'];
		}
	});
	if (counter < 5) {
		showMore.disabled = true;
	}
}
let button = document.querySelector('.gallery__show-more');
button.onclick = function(){
	let id = {
		id: "",
	};
	id.id = document.querySelector('.gallery__show-more').dataset.id;
	ajax('/photo/showMore', 'POST', showMore, id);
};
// ajax('/photo/showMore', 'POST', showMore, id);	

// showMore(["/public/images/gallery/1/4f71e3b252b419cdd94c5484589aae20.jpg", "/public/images/gallery/1/4f71e3b252b419cdd94c5484589aae20.jpg"]);
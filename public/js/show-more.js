let id = {
	id: "",
};
id.id = document.querySelector('.gallery__show-more').dataset.id;
function showMore(srcs) {
	// let button = document.querySelector('.gallery__show-more');
	let grid = document.querySelector('.gallery__grid');
	// button.onclick = function(){
		srcs.forEach(element => {
			let img = document.createElement('img');
			img.src = '/Camagru/public/images/gallery/';
			img.src += element['user_id'];
			img.src += '/';
			img.src += element['photo_src'];
			img.classList.add('gallery__grid-item');
			grid.appendChild(img);	
		});
	// }
}
let button = document.querySelector('.gallery__show-more');
button.onclick = function(){
	ajax('/Camagru/photo/showMore', 'POST', showMore, id);
};
// ajax('/Camagru/photo/showMore', 'POST', showMore, id);	

// showMore(["/Camagru/public/images/gallery/1/4f71e3b252b419cdd94c5484589aae20.jpg", "/Camagru/public/images/gallery/1/4f71e3b252b419cdd94c5484589aae20.jpg"]);
/**
 * Функция formMaskInformation() - формирует информацию о наложенной
 * маске
 * 
 * Получаем объект mask - наложенную маску
 * 
 * Проверяем наложена ли маска на изображение, если наложена, 
 * то получаем объекты со стилями для маски - styles,
 * для контейнера изображения - windowStyles,
 * maskWindow - контейнер для изображения, нужен для масштабирования
 * размера и положения маски на сервере, так как по умолчанию ширина 
 * изображения 1920px, но она масштабируется под размер контейнера
 * 
 * в объекте info содержится информация для правильного
 * расположения масок на фотографии
 * src - название накладываемой маски (путь к маске), 
 * width - ширина маски, height - высота маски
 * top - смещение маски от верхнего края фотографии
 * left - смещение маски от левого края фотографии
 * 
 * Информацию о масках помещаем в скрытое поле 
 * с классом .photo__hidden-info
 */
function formMaskInformation() {
	let mask = document.querySelector('.photo__container .photo__mask-img');
	if (mask != null) {
		let maskWindow = document.querySelector('.photo__output');
		let styles = window.getComputedStyle(mask);
		let windowStyles = window.getComputedStyle(maskWindow);
		let info = {};
		if (styles != null) {
			info = {
				src: mask.src,
				width: styles.getPropertyValue("width"),
				height: styles.getPropertyValue("height"),
				top: styles.getPropertyValue("top"),
				left: styles.getPropertyValue("left"),
				windowWidth: windowStyles.getPropertyValue("width"),
				windowHeight: windowStyles.getPropertyValue("height"),
			};	
		}
		document.querySelector(".photo__hidden-info").value = JSON.stringify(info);
	}
	document.querySelector('.photo__form').submit();
}

(function() {
	// The width and height of the captured photo. We will set the
	// width to the value defined here, but the height will be
	// calculated based on the aspect ratio of the input stream.

	let width = 1920;    // We will scale the photo width to this
	let height = 0;     // This will be computed based on the input stream

	// |streaming| indicates whether or not we're currently streaming
	// video from the camera. Obviously, we start at false.

	let streaming = false;

	// The various HTML elements we need to configure or control. These
	// will be set by the startup() function.

	let video = null;
	let canvas = null;
	let startbutton = null;

	function startup() {
		video = document.getElementById('video');
		canvas = document.getElementById('canvas');
		startbutton = document.getElementById('startbutton');

		navigator.mediaDevices.getUserMedia({video: true, audio: false})
		.then(function(stream) {
			video.srcObject = stream;
			video.play();
		})
		.catch(function(err) {
			console.log("An error occurred: " + err);
		});

		video.addEventListener('canplay', function(ev){
		if (!streaming) {
			height = video.videoHeight / (video.videoWidth/width);
		
			// Firefox currently has a bug where the height can't be read from
			// the video, so we will make assumptions if this happens.
		
			if (isNaN(height)) {
			height = width / (4/3);
			}
		
			video.setAttribute('width', width);
			video.setAttribute('height', height);
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			streaming = true;
		}
		}, false);

		startbutton.addEventListener('click', function(ev){
		takepicture();
		ev.preventDefault();
		}, false);
	}
	
	// Capture a photo by fetching the current contents of the video
	// and drawing it into a canvas, then converting that to a PNG
	// format data URL. By drawing it on an offscreen canvas and then
	// drawing that to the screen, we can change its size and/or apply
	// other changes before drawing it.

	function takepicture() {
		let context = canvas.getContext('2d');
		if (width && height) {
			canvas.width = width;
			canvas.height = height;
			context.drawImage(video, 0, 0, width, height);
			/**
			 * метод toDataURL() возвращает data URL содержащий представление изображения
			 * в формате определенном параметром type
			 * encoderOptions параметр означает качество изображения для форматов,
			 * которые используют сжатие с потерей качества (image/jpeg)
			 * Фотографию помещаем в скрытое поле формы .photo__hidden
			 */
			let data = canvas.toDataURL('image/jpeg', 1);
			document.querySelector(".photo__hidden").value = data;
			document.querySelector('.photo__video').style.display = "none";
			document.querySelector('.photo__button').style.display = "none";

			document.querySelector('.photo__exit-button').style.display = 'block';
			let div = document.createElement('div');
			document.querySelector('.photo__container').style.minHeight = '0px';
			document.querySelector('.photo__button-public').disabled = false;
			div.classList.add("photo__output");
            div.innerHTML = ['<img class="photo__preview"', ' src="', data, '" />'].join('');
			document.querySelector('.photo__container').insertBefore(div, document.querySelector('.photo__video'));
		}
	}

	// Set up our event listener to run the startup process
	// once loading is complete.
	window.addEventListener('load', startup, false);
	})();
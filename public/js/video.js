/**
 * formMaskInformation() - genereates information about
 * the applied mask and puts it in a hidden field as JSON.
 */
function formMaskInformation() {
	let nodeListOfMasks = document.querySelectorAll('.photo__container .photo__mask-img');
	let info = {};
	let maskWindow = document.querySelector('.photo__output');
	let windowStyles = window.getComputedStyle(maskWindow);
	if (nodeListOfMasks.length != 0) {
		for (let i=0; i < nodeListOfMasks.length; i++) {
			let styles = window.getComputedStyle(nodeListOfMasks[i]);
			info[i] = {
				src: nodeListOfMasks[i].src,
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

/**
 * The width and height of the captured photo. We will set the
 * width to the value defined here, but the height will be
 * calculated based on the aspect ratio of the input stream.
 * width - We will scale the photo width to this
 * This will be computed based on the input stream
 * streaming - indicates whether or not we're currently streaming
 * video from the camera. We start at false.
 * video, canvas, startbutton - HTML elements we need to configure 
 * or control. These will be set by the startup() function.
 */
(function() {
	let width = 1920;
	let height = 0;
	let streaming = false;
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

	function takepicture() {
		let context = canvas.getContext('2d');
		if (width && height) {
			canvas.width = width;
			canvas.height = height;
			context.drawImage(video, 0, 0, width, height);
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
	window.addEventListener('load', startup, false);
})();
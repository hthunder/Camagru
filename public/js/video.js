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
			let data;
			let mask;
			let maskWindow;
			let styles;
			let windowStyles;
			let info;
			let preview;
			let exit;
			let div;

			canvas.width = width;
			canvas.height = height;
			context.drawImage(video, 0, 0, width, height);
			data = canvas.toDataURL('image/jpeg', 1);
			mask = document.querySelector('.photo__container .photo__mask-img');
			maskWindow = document.querySelector('.photo__video');
			styles = null;
			if (mask != null) {
				styles = window.getComputedStyle(mask, null);	
			}
			windowStyles = window.getComputedStyle(maskWindow, null);
			document.querySelector(".photo__hidden").value = data;
			info = {
				src: null,
				width: null,
				height: null,
				top: null,
				left: null,
			};
			if (mask != null && styles != null) {
				info.src = mask.src;
				info.width = styles.getPropertyValue("width");
				info.height = styles.getPropertyValue("height");
				info.top = styles.getPropertyValue("top");
				info.left = styles.getPropertyValue("left");	
			}
			info.windowWidth = windowStyles.getPropertyValue("width");
			info.windowHeight = windowStyles.getPropertyValue("height");
			document.querySelector(".photo__hidden-info").value = JSON.stringify(info);
			
			// document.querySelector(".photo__form").submit();
			
			preview = document.querySelector('.photo__preview');
			document.querySelector('.photo__video').style.display = "none";
			exit = document.querySelector('.photo__exit-button');
            exit.style.display = "block";
			div = document.createElement('div');
			div.classList.add("photo__output");
            div.innerHTML = ['<img class="photo__preview"', ' src="', data, '" />'].join('');
			document.querySelector('.photo__container').insertBefore(div, document.querySelector('.photo__video'));
		}
	}

	// Set up our event listener to run the startup process
	// once loading is complete.
	window.addEventListener('load', startup, false);
	})();
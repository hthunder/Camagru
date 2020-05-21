<!DOCTYPE html>
<html lang="ru">
<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
	<?php include(ROOT . "/views/layouts/_head.php"); ?>
	<body class="body">
		<div class="photo">
			<div class="top-line">	
			</div>
			<div class="container">
        <?php include(ROOT . '/views/layouts/_burger.php'); ?>
        <div class="photo__container">
          <video class="photo__video" id="video">Video stream not available.</video>
          <button class="button-4 photo__button" id="startbutton"><img class="button-4__img" src="/Camagru/public/images/icons/camera_white.svg" alt=""></button>
        </div>
        <?php include(ROOT . '/views/layouts/_slider.php'); ?>
        <a class="link link_underline photo__link" href="">Выбрать из моб. галереи</a>
        <input class="button-2 button-2_inverse" type="button" value="Опубликовать">
			</div>




      
			<canvas id="canvas">
      </canvas>
      
			<img id="russia" src="/Camagru/public/images/masks/russia.png" alt="">
			<div class="output">
				<img id="photo" alt="The screen capture will appear in this box.">
			</div>
		</div>
		<script>
			(function() {
  // The width and height of the captured photo. We will set the
  // width to the value defined here, but the height will be
  // calculated based on the aspect ratio of the input stream.

  var width = 320;    // We will scale the photo width to this
  var height = 0;     // This will be computed based on the input stream

  // |streaming| indicates whether or not we're currently streaming
  // video from the camera. Obviously, we start at false.

  var streaming = false;

  // The various HTML elements we need to configure or control. These
  // will be set by the startup() function.

  var video = null;
  var canvas = null;
  var photo = null;
  var startbutton = null;

  function startup() {
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    photo = document.getElementById('photo');
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
    
    clearphoto();
  }

  // Fill the photo with an indication that none has been
  // captured.

  function clearphoto() {
    var context = canvas.getContext('2d');
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, canvas.width, canvas.height);

    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
  }
  
  // Capture a photo by fetching the current contents of the video
  // and drawing it into a canvas, then converting that to a PNG
  // format data URL. By drawing it on an offscreen canvas and then
  // drawing that to the screen, we can change its size and/or apply
  // other changes before drawing it.

  function takepicture() {
    var context = canvas.getContext('2d');
    if (width && height) {
      canvas.width = width;
      canvas.height = height;
      context.drawImage(video, 0, 0, width, height);
	  context.drawImage(document.getElementById('russia'), 30, 0);
    
      var data = canvas.toDataURL('image/png');
      photo.setAttribute('src', data);
    } else {
      clearphoto();
    }
  }

  // Set up our event listener to run the startup process
  // once loading is complete.
  window.addEventListener('load', startup, false);
})();
    </script>
    <script src="/Camagru/public/js/slider.js"></script>
	</body>
</html>
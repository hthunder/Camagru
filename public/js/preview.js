function handleFileSelect(evt) {
    let file = evt.target.files; // FileList object
    let f = file[0];
    let preview = document.querySelector('.photo__preview');
    if (preview) {
        preview.remove();
    }
    document.querySelector('.photo__video').style.display = "none";
    // Only process image files.
    if (!f.type.match('image.*')) {
        alert("Image only please....");
    }
    let reader = new FileReader();
    // Closure to capture the file information.
    reader.onload = (function(theFile) {
        return function(e) {
            // Render thumbnail.
			let div = document.createElement('div');
            div.innerHTML = ['<img class="photo__preview" title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
			document.querySelector('.photo__container').insertBefore(div, document.querySelector('.photo__video'));
        };
    })(f);
    // Read in the image file as a data URL.
    reader.readAsDataURL(f);
}
document.getElementById('custom-file').addEventListener('change', handleFileSelect, false);
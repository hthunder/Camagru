function handleFileSelect(evt) {
    let file = evt.target.files[0]; // FileList object
    let preview = document.querySelector('.photo__preview');
    if (preview) {
        preview.parentNode.remove();
    }
    document.querySelector('.photo__video').style.display = "none";
    // Only process image files.
    if (!file.type.match('image.*')) {
        alert("Загрузите пожалуйста изображение");
    }
    let reader = new FileReader();
    // Closure to capture the file information.
    reader.onload = (function(theFile) {
        return function(e) {
            // Render thumbnail.
            let div = document.createElement('div');
            let exit = document.querySelector('.photo__exit-button');

            exit.style.display = "block";
            div.classList.add("photo__output");
            div.innerHTML = ['<img class="photo__preview" title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
			document.querySelector('.photo__container').insertBefore(div, document.querySelector('.photo__video'));
        };
    })(file);
    // Read in the image file as a data URL.
    reader.readAsDataURL(file);
}
document.getElementById('custom-file').addEventListener('change', handleFileSelect, false);
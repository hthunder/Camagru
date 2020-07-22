'use strict';

function handleFileSelect(evt) {
    let file = evt.target.files[0];
    let preview = document.querySelector('.photo__preview');
    let label = document.querySelector('.custom-input__label');
    let fileName = this.value.split('\\').pop();
    console.log('hi');
    if (file) {
        if (preview) {
            preview.parentNode.remove();
        }
        document.querySelector('.photo__video').style.display = "none";
        if (!file.type.match('image.jpeg')) {
            alert("Загрузите пожалуйста изображение в формате jpeg");
            document.querySelector('.photo__video').style.display = 'block';
            label.innerHTML = labelVal;
        } else {
            label.querySelector('.custom-input__span').innerHTML = fileName;
            let reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                    let div = document.createElement('div');
                    let exit = document.querySelector('.photo__exit-button');
                    
                    document.querySelector('.photo__button').style.display = 'none';
                    document.querySelector('.photo__container').style.minHeight = '0px';
                    document.querySelector('.photo__button-public').disabled = false;
                    exit.style.display = "block";
                    div.classList.add("photo__output");
                    div.innerHTML = ['<img class="photo__preview" title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
                    document.querySelector('.photo__container').insertBefore(div, document.querySelector('.photo__video'));
                    document.querySelector(".photo__hidden").value = this.result;
                };
            })(file);.
            reader.readAsDataURL(file);    
        }
    }
}
document.querySelector('.custom-input__file').addEventListener('change', handleFileSelect, false);
'use strict';

(function () {
	let input = document.querySelector('.custom-input__file');
	let label = input.nextElementSibling
	let labelVal = label.innerHTML;

	input.addEventListener('change', function(e){
		let fileName = '';
		fileName = e.target.value.split( '\\' ).pop();

		if (fileName)
			label.querySelector('.custom-input__span').innerHTML = fileName;
		else
			label.innerHTML = labelVal;
	});
}());
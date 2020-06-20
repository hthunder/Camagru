document.querySelector('.page__likes-icon').addEventListener('click', like);

function like(event) {
	const regex = RegExp('like.svg');
	let temp = document.querySelector('.page__likes-number').innerText;
	if (regex.test(event.target.src)) {
		event.target.src = '/public/images/icons/likePushed.svg';
		document.querySelector('.page__likes-number').innerText = +temp + 1;
		ajax('/like/addRemove', 'POST', console.log, {
			like: 'true',
			photoName: event.target.dataset.photoName,
		})
	}	
	else {
		event.target.src = '/public/images/icons/like.svg';
		document.querySelector('.page__likes-number').innerText = +temp - 1;
		ajax('/like/addRemove', 'POST', console.log, {
			like: 'false',
			photoName: event.target.dataset.photoName,
		})
	}	
}

// XMLHttpRequest
// function ajax(url, method, functionName, dataArray) {
//     let xhttp = new XMLHttpRequest();
//     xhttp.open(method, url, true);
//     xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     xhttp.send(requestData(dataArray));

//     xhttp.onreadystatechange = function () {
//         if (this.readyState == 4 && this.status == 200) {
//             console.log(JSON.parse(this.response));
//             functionName(JSON.parse(this.response));
//         }
//     }
// }

// function requestData(data) {
// 	let urlEncodedDataPairs = [];
// 	let urlEncodedData = '';
	
	// Turn the data object into an array of URL-encoded key/value pairs.
	// for (let name in data ) {
	// 	urlEncodedDataPairs.push(encodeURIComponent(name) + '=' + encodeURIComponent(data[name]));
	// }
	// Combine the pairs into a single string and replace all %-encoded spaces to 
	// the '+' character; matches the behaviour of browser form submissions.
// 	urlEncodedData = urlEncodedDataPairs.join('&').replace(/%20/g, '+');
//     return urlEncodedData;
// }


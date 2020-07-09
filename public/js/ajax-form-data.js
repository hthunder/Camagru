function ajaxFormData(form, url, method, extraRequestData, responseHandler) {
    let formData = new FormData(form);
    let request = new XMLHttpRequest();
    request.open(method, url);
    if (extraRequestData != null) {
        for (let key in extraRequestData) {
            formData.append(key, extraRequestData[key]);
        }
    }
    request.send(formData);
    request.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (responseHandler !== null && this.response !== "")
                responseHandler(JSON.parse(this.response));
        }
    }
}
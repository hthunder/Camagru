let delete_form = document.querySelector(".page__delete-form");

if (delete_form) {
    delete_form.onsubmit = function(){
        if (confirm("Вы точно хотите удалить эту фотографию?"))
            this.submit();
        else
            event.preventDefault();
    };
}

let delete_form = document.querySelector(".page__delete-form");
delete_form.onsubmit = function(){
    // event.preventDefault();
    if (confirm("Вы точно хотите удалить эту фотографию"))
        this.submit();
    else
        event.preventDefault();
};
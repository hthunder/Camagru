let modal = document.querySelector(".modal");
let btn = document.querySelector(".cabinet__button_modal");
let span = document.querySelector(".modal__close");

/**
 * When the user clicks on the button, open the modal
 */
btn.onclick = function() {
    modal.style.display = "block";
    document.querySelector(".body").style.overflow = "hidden";
    document.querySelector(".modal__input-username").value = document.querySelector(".cabinet__input_username").value;
    document.querySelector(".modal__input-email").value = document.querySelector(".cabinet__input_email").value;
}

/**
 * When the user clicks on <span> (x), close the modal
 */
span.onclick = function() {
    modal.style.display = "none";
    document.querySelector(".body").style.overflow = "";
}

/**
 * When the user clicks anywhere outside of the modal, close it
 */
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        document.querySelector(".body").style.overflow = "";
    }
}
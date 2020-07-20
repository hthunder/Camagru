let customElements = document.querySelectorAll('.checkbox__custom-element');

for (let i = 0; i < customElements.length; i++) {
    customElements[i].addEventListener('click', notifications);
}

function notifications(event) {
    ajax('/user/notifications', 'POST', null, {
        notifications: "change",
    })
}

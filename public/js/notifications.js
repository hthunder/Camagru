let customElement = document.querySelector('.checkbox__custom-element');

if (customElement)
    customElement.addEventListener('click', notifications);

function notifications(event) {
    ajax('/user/notifications', 'POST', null, {
        notifications: "change",
    })
}

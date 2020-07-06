document.querySelector('.checkbox__custom-element').addEventListener('click', notifications);

function notifications(event) {
    ajax('/user/notifications', 'POST', null, {
        notifications: "change",
    })
}

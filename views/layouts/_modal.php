<button class="cabinet__button cabinet__button_modal" type="button">Изменить</button>
<div class="modal">
    <form class="modal__form" method="POST" action="/cabinet/changeInfo">
        <span class="modal__close">&times;</span>
        <input class="modal__input-username" type="hidden" name="username">
        <input class="modal__input-email" type="hidden" name="email">
        <input class="modal__input-password cabinet__input" type="password" name="password" placeholder="Введите ваш пароль">
        <button class="modal__button cabinet__button" type="submit" name="changeInfo">Сохранить</button>
    </form>
</div>
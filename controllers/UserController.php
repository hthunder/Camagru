<?php

/**
 * Контроллер UserController
 */
class UserController
{
    /**
     * Action для страницы "Регистрация"
     */
    public function actionRegister()
    {
        // Переменные для формы
        $name = false;
        $email = false;
        $password = false;
        $result = false;

        // Обработка формы
        if (isset($_POST['signup'])) {
            // Если форма отправлена 
            // Получаем данные из формы
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Флаг ошибок
            $errors = false;

            // Валидация полей
            if (!User::checkUsername($username)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (User::checkUsernameExists($username)) {
                $errors[] = 'Такое имя пользователя уже используется';
            }
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }
            if ($errors == false) {
                // Если ошибок нет
                // Регистрируем пользователя
                $activation_code = md5($email . time());
                $result = User::register($username, $email, $password, $activation_code);
                header('Location: /Camagru');
            }
        }

        // Подключаем вид
        $title = 'Форма регистрации';
        require_once(ROOT . '/views/user/register.php');
        return true;
    }

    /*
    ** Action для активация профиля пользователя
    **
    */

    public function actionActivation() {

    }
    
    /**
     * Action для страницы "Вход на сайт"
     */
    public function actionLogin()
    {
        // Переменные для формы
        $email = false;
        $password = false;
        
        // Обработка формы
        if (isset($_POST['login'])) {
            // Если форма отправлена 
            // Получаем данные из формы
            $email_username = $_POST['email_username'];
            $password = $_POST['password'];

            // Флаг ошибок
            $errors = false;

            // Проверяем существует ли пользователь
            $userId = User::checkUserData($email_username, $password);

            if ($userId == false) {
                // Если данные неправильные - показываем ошибку
                $errors[] = 'Неправильные данные для входа на сайт';
                // var_dump($errors);
            } else {
                // Если данные правильные, запоминаем пользователя (сессия)
                User::auth($userId);

                // Перенаправляем пользователя в закрытую часть - кабинет 
                // echo("Все ок");
                header("Location: /Camagru/cabinet");
            }
        }

        // Подключаем вид
        $title = 'Форма логина';
        require_once(ROOT . '/views/user/login.php');
        return true;
    }

    /**
     * Удаляем данные о пользователе из сессии
     */
    public function actionLogout()
    {
        // Стартуем сессию
        // session_start();
        
        // Удаляем информацию о пользователе из сессии
        unset($_SESSION["user"]);
        
        // Перенаправляем пользователя на главную страницу
        header("Location: /Camagru");
    }

    public function actionPhoto()
    {
        $title = 'Сделать фото';
        require_once(ROOT . '/views/user/photo.php');
        return true;
    }


    // public function actionCreatePhoto()
    // {
    //     User::createPhoto();
    //     echo "I tried";
    //     return true;
    // }
}

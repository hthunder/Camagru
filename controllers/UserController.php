<?php

/**
 * Контроллер UserController
 */
class UserController
{
    /**
     * Action for a register page. Error handling
     * and rendering of the register page.
     */
    
    public function actionRegister()
    {
        $array = array(
            "username" => !empty($_POST["username"]) ? $_POST["username"] : "", 
            "email" => !empty($_POST["email"]) ? $_POST["email"] : "",
            "pass1" => !empty($_POST["pass1"]) ? $_POST["pass1"] : "",
            "pass2" => !empty($_POST["pass2"]) ? $_POST["pass2"] : "",
            "title" => "Форма регистрации",
            "errors" => "",
        );
        if (isset($_POST["signup"])) {
            if ($array["username"] && $array["email"] && $array["pass1"] && $array["pass2"]) {
                $array["errors"] = User::isRegistrationValid($array);
                if ($array["errors"] === "") {
                    $activation_code = md5($array["email"] . time());
                    $result = User::register($array["username"], $array["email"], 
                    $array["pass1"], $activation_code);
                    User::sendMail($email, "Подтверждение регистрации", $activation_code);
                    header('Location: /');
                }
            } else {
                $array["errors"] .= "Не все поля заполнены";
            }
        }
        ob_start();
        include_once(ROOT . '/views/user/register.php');
        $file = ob_get_contents();
        ob_end_clean();
        $file = Template::render($array, $file);
        print($file);
        return true;
    }

    /*
    ** Action для активация профиля пользователя
    **
    */

    public function actionActivation($activation_code) {
        echo (User::activation($activation_code));
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
            $error = false;

            // Проверяем существует ли пользователь
            $userId = User::checkUserData($email_username, $password);
            if ($userId == -2) {
                // Если данные неправильные - показываем ошибку
                $error = 'Активируйте учетную запись через письмо на почте';
                // var_dump($errors);
            } else if ($userId == -1) {
                $error = 'Неправильно введено имя пользователя или пароль';
            } else {
                // Если данные правильные, запоминаем пользователя (сессия)
                User::auth($userId);

                // Перенаправляем пользователя в закрытую часть - кабинет 
                header("Location: /cabinet");
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
        header("Location: ");
    }

    // public function actionMailConfirm() {
    //     $string  = 'April 15, 2003';
    //     $pattern = '/(\w+) (\d+), (\d+)/i';
    //     $replacement = '$1 1, $3';
    //     echo preg_replace($pattern, $replacement, $string);
    //     echo '<br>';
    //     echo $string;
    //     echo '<br>';
    //     echo $pattern;
    //     echo '<br>';
    //     echo $replacement;
    // }
    // public function actionCreatePhoto()
    // {
    //     User::createPhoto();
    //     echo "I tried";
    //     return true;
    // }
}

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
                    User::sendMail($array["email"], "Подтверждение регистрации", $activation_code);
                    header('Location: /');
                    exit();
                }
            } else {
                $array["errors"] .= "Не все поля заполнены";
            }
        }
        print(Template::render($array, ROOT . '/views/user/register.php'));
        return true;
    }

    /*
    ** Action for activation by mail
    */

    public function actionActivation($activation_code) {
        User::activation($activation_code);
        header("Location: /");
        return true;
    }
    
    /**
     * Action for a login page
     */
    public function actionLogin()
    {
        $array = array(
            "email_username" => !empty($_POST["email_username"]) ? $_POST["email_username"] : "",
            "password" => !empty($_POST["password"]) ? $_POST["password"] : "",
            "title" => "Форма логина",
            "errors" => "",
        );
        if (isset($_POST["login"])) {
            if ($array["email_username"] && $array["password"]) {
                $array["errors"] = User::login($array);
            } else {
                $array["errors"] .= "Не все поля заполнены";
            }
        }
        print(Template::render($array, ROOT . '/views/user/login.php'));
        return true;
    }

    /**
     * Удаляем данные о пользователе из сессии
     */
    public function actionLogout()
    {
        if (isset($_POST["logout"]))
            unset($_SESSION["user"]);
        header("Location: /");
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

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
        if (User::isLogged()) {
            header("Location: /cabinet");
            exit();
        }
        $array = array(
            "username" => !empty($_POST["username"]) ? mb_substr($_POST["username"], 0, 30, "UTF-8") : "", 
            "email" => !empty($_POST["email"]) ? mb_substr($_POST["email"], 0, 30, "UTF-8") : "",
            "pass1" => !empty($_POST["pass1"]) ? mb_substr($_POST["pass1"], 0, 60, "UTF-8") : "",
            "pass2" => !empty($_POST["pass2"]) ? mb_substr($_POST["pass2"], 0, 60, "UTF-8") : "",
            "title" => "Форма регистрации",
            "errors" => "",
            "transparency" => "header_bg_transparent",
        );
        if (isset($_POST["signup"])) {
            if ($array["username"] && $array["email"] && $array["pass1"] && $array["pass2"]) {
                $array["errors"] = User::isRegistrationValid($array);
                if ($array["errors"] === "") {
                    $activation_code = md5($array["email"] . time());
                    $result = Common::insertRow(array("username" => $array["username"],
                        "email" => $array["email"], 
                        "password" => password_hash($array["pass1"], PASSWORD_BCRYPT),
                        "activation_code" => $activation_code), "users");
                    User::sendMail($array["email"], "Подтверждение регистрации", $activation_code);
                    $_SESSION["message"] = "Письмо для подтверждения регистрации было выслано Вам на почту";
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
        if (User::isLogged()) {
            header("Location: /cabinet");
            exit();
        }
        $array = array(
            "email_username" => !empty($_POST["email_username"]) ? $_POST["email_username"] : "",
            "password" => !empty($_POST["password"]) ? $_POST["password"] : "",
            "title" => "Форма логина",
            "errors" => "",
            "transparency" => "header_bg_transparent",
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
        if (isset($_POST["logout"])) {
           unset($_SESSION["id"]);
           unset($_SESSION["notifications"]);
           unset($_SESSION["username"]);
        }
        header("Location: /");
    }

    public function actionForgotPass()
    {
        if (User::isLogged()) {
            header("Location: /cabinet");
            exit();
        }
        $array = array(
            "email" => !empty($_POST["email"]) ? $_POST["email"] : "",
            "title" => "Восстановление пароля",
            "errors" => "",
            "transparency" => "header_bg_transparent",
        );
        if (isset($_POST["forgotPass"])) {
            if ($array["email"]) {
                $userInfo = Common::getRowsBy("email", $array["email"], "users")->fetch();
                User::sendMail($array["email"], "Ссылка для восстановления пароля", $userInfo["activation_code"]);
                header('Location: /user/login');
                exit();
            } else {
                $array["errors"] .= "Не все поля заполнены";
            }
        }
        print(Template::render($array, ROOT . '/views/user/forgotPass.php'));
        return true;
    }

    public function actionChangePass($activationCode)
    {
        if (User::isLogged()) {
            header("Location: /cabinet");
            exit();
        }
        $array = array(
            "pass1" => !empty($_POST["pass1"]) ? mb_substr($_POST["pass1"], 0, 60, "UTF-8") : "",
            "pass2" => !empty($_POST["pass2"]) ? mb_substr($_POST["pass2"], 0, 60, "UTF-8") : "",
            "activationCode" => !empty($activationCode) ? $activationCode : "", 
            "title" => "Форма изменения пароля",
            "errors" => "",
            "transparency" => "header_bg_transparent",
        );
        if (isset($_POST["changePass"])) {
            if ($array["pass1"] && $array["pass2"]) {
                $user = Common::getRowsBy("activation_code", $array["activationCode"], "users")->fetch();
                if ($array["pass1"] == $array["pass2"]) {
                    if (mb_strlen($array["pass1"]) < 6) {
                        $array["errors"] .= 'Пароль не должен быть короче 6-ти символов</br>';    
                    } else {
                        $dataForUpdate = array("password" => password_hash($array["pass1"], PASSWORD_BCRYPT));
                        Common::updateRow($dataForUpdate, $user['id']);
                        header('Location: /user/login');
                        exit();    
                    }
                } else {
                    $array["errors"] .= 'Пароли должны совпадать</br>';
                }
            } else {
                $array["errors"] .= "Не все поля заполнены</br>";
            }
        }
        print(Template::render($array, ROOT . '/views/user/changePass.php'));
        return true;
    }

    public function actionNotifications()
    {
        if (isset($_POST["notifications"]) && !empty($_SESSION["id"]) && $_POST["notifications"] === "change") {
            $result = User::notificationsToggle();
            $notificationsStatus = Common::getRowsBy("id", $_SESSION["id"], "users")->fetch();
            $_SESSION["notifications"] = $notificationsStatus["notifications"];
            header('Content-Type: application/json');
            echo json_encode(['response' => "$result"]);    
        } else {
            header('Content-Type: application/json');
            echo json_encode(["response" => null]);
        }
        return true;
    }
}

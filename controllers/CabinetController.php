<?php

/**
 * Контроллер CabinetController
 * Кабинет пользователя
 */
class CabinetController
{

    /**
     * Action для страницы "Кабинет пользователя"
     */
    public function actionIndex()
    {
        $userId = User::checkLogged();
        $user = User::getUserBy("id", $userId);
        $array = array(
            "username" => !empty($user["username"]) ? $user["username"] : "",
            "email" => !empty($user["email"]) ? $user["email"] : "",
            "avatar_src" => !empty($user["avatar_src"]) ? $user["avatar_src"] : "avatar.jpg",
            "errors" => !empty($_SESSION["editErrors"]) ? $_SESSION["editErrors"] : "",
            "title" => "Кабинет пользователя",
        );
        if (isset($_SESSION["editErrors"]))
            unset($_SESSION["editErrors"]);
        foreach($array as $key => $value) {
            $array[$key] = htmlspecialchars($value);
        }
        print(Template::render($array, ROOT . '/views/cabinet/index.php'));
        return true;
    }

    /**
     * A changeInfo action lets to update a user login and email
     */
    public function actionChangeInfo() {
        User::checkLogged();
        $array = array(
            "username" => !empty($_POST["username"]) ? substr($_POST["username"], 0, 30) : "",
            "email" => !empty($_POST["email"]) ? substr($_POST["email"], 0, 30) : "",
            "password" => !empty($_POST["password"]) ? $_POST["password"] : "",
            "errors" => "",
        );
        if (isset($_POST["changeInfo"])) {
            if ($array["username"] && $array["email"] && $array["password"]) {
                $array["errors"] .= User::changeInfoValidation($array);
                if ($array["errors"] === "") {
                    $user = User::getUserBy('id', $_SESSION["user"]);
                    if ($user && password_verify($array["password"], $user["password"])) {
                        $newArray = array(
                            "email" => $array["email"],
                            "username" => $array["username"],
                        );
                        if (!User::updateUserData($newArray, $_SESSION["user"]))
                            $array["errors"] .= "Что-то пошло не так</br>";
                    } else {
                       $array["errors"] .= "Введен неверный пароль</br>"; 
                    }
                }
            } else {
                $array["errors"] .= "Не все поля заполнены</br>";
            }
        }
        $_SESSION["editErrors"] = $array["errors"];
        header("Location: /cabinet");
        exit();
    }

    /**
     * An action changePass for a cabinet
     */

    public function actionChangePass()
    {
        User::checkLogged();
        $array = array(
            "pass1" => !empty($_POST["pass1"]) ? substr($_POST["pass1"], 0, 60) : "",
            "pass2" => !empty($_POST["pass2"]) ? substr($_POST["pass2"], 0, 60) : "",
            "oldPass" => !empty($_POST["oldPass"]) ? substr($_POST["oldPass"], 0, 60) : "",
            "errors" => "",
        );
        if (isset($_POST["changePass"])) {
            if ($array["pass1"] && $array["pass2"] && $array["oldPass"]) { 
                $userInfo = User::getUserBy("id", $_SESSION["user"]);
                if ($userInfo && password_verify($array["oldPass"], $userInfo["password"])) {
                    if ($array["pass1"] == $array["pass2"]) {
                        if (strlen($array["pass1"]) < 6) {
                            $array["errors"] .= 'Пароль не должен быть короче 6-ти символов</br>';    
                        } else {
                            $dataForUpdate = array("password" => password_hash($array["pass1"], PASSWORD_BCRYPT));
                            User::updateUserData($dataForUpdate, $userInfo['id']);
                            header('Location: /cabinet');
                            exit();    
                        }
                    } else {
                        $array["errors"] .= 'Пароли должны совпадать</br>';
                    }
                } else {
                    $array["errors"] .= "Вы ввели неверный старый пароль</br>";
                }
            } else {
                $array["errors"] .= "Не все поля заполнены</br>";
            }
        }
        print(Template::render($array, ROOT . '/views/user/changePass.php'));
        return true;
    }
}
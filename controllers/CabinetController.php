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
        print(Template::render($array, ROOT . '/views/cabinet/index.php'));
        return true;
    }

    public function actionChangeInfo() {
        $array = array(
            "username" => !empty($_POST["username"]) ? $_POST["username"] : "",
            "email" => !empty($_POST["email"]) ? $_POST["email"] : "",
            "password" => !empty($_POST["password"]) ? $_POST["password"] : "",
            "errors" => "",
        );
        if (isset($_POST["changeInfo"])) {
            if ($array["username"] && $array["email"] && $array["password"]) {
                $array["errors"] .= User::changeInfo($array);
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
}

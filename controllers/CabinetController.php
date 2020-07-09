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
        $user = Common::getRowsBy("id", $userId, "users")->fetch();
        $array = array(
            "username" => !empty($user["username"]) ? $user["username"] : "",
            "email" => !empty($user["email"]) ? $user["email"] : "",
            "avatar_src" => !empty($user["avatar_src"]) ? $user["avatar_src"] : "avatar.jpg",
            "errors" => !empty($_SESSION["editErrors"]) ? $_SESSION["editErrors"] : "",
            "cabinet__grid" => "",
            "title" => "Кабинет пользователя",
            "checked" => isset($_SESSION["notifications"]) && $_SESSION["notifications"] == 1 ? "checked" : "", 
        );
        $photosArray = Common::getRowsBy("user_id", $_SESSION["id"], "photos", "desc");
        if ($photosArray) {
            $counter = 0;
            while ($row = $photosArray->fetch()) {
                if ($counter > 5)
                    break;
                $photo_src = explode('.', $row["photo_src"])[0];
			    $file_name = $row["photo_src"];
			    $str = "<a class='cabinet__grid-link' href='/photo/page/{photo_userid}/{photo_src}'>
						    <img class='cabinet__grid-item' src='/public/images/gallery/{photo_userid}/{file_name}'>
                        </a>";
                $str = str_replace("{photo_userid}", $_SESSION["id"], $str);
			    $str = str_replace("{photo_src}", $photo_src, $str);
                $str = str_replace("{file_name}", $file_name, $str);
                $array["cabinet__grid"] .= $str;
                $counter++;
            }
        }
        if (isset($_SESSION["editErrors"]))
            unset($_SESSION["editErrors"]);
        foreach($array as $key => $value) {
            if ($key != "cabinet__grid")
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
            "username" => !empty($_POST["username"]) ? mb_substr($_POST["username"], 0, 30, "UTF-8") : "",
            "email" => !empty($_POST["email"]) ? mb_substr($_POST["email"], 0, 30, "UTF-8") : "",
            "password" => !empty($_POST["password"]) ? $_POST["password"] : "",
            "errors" => "",
        );
        if (isset($_POST["changeInfo"])) {
            if ($array["username"] && $array["email"] && $array["password"]) {
                $array["errors"] .= User::changeInfoValidation($array);
                if ($array["errors"] === "") {
                    $user = Common::getRowsBy("id", $_SESSION["id"], "users")->fetch();
                    if ($user && password_verify($array["password"], $user["password"])) {
                        $newArray = array(
                            "email" => $array["email"],
                            "username" => $array["username"],
                        );
                        if (!Common::updateRow($newArray, $_SESSION["id"]))
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
            "pass1" => !empty($_POST["pass1"]) ? mb_substr($_POST["pass1"], 0, 60, "UTF-8") : "",
            "pass2" => !empty($_POST["pass2"]) ? mb_substr($_POST["pass2"], 0, 60, "UTF-8") : "",
            "oldPass" => !empty($_POST["oldPass"]) ? mb_substr($_POST["oldPass"], 0, 60, "UTF-8") : "",
            "errors" => "",
        );
        if (isset($_POST["changePass"])) {
            if ($array["pass1"] && $array["pass2"] && $array["oldPass"]) { 
                $userInfo = Common::getRowsBy("id", $_SESSION["id"], "users")->fetch();
                if ($userInfo && password_verify($array["oldPass"], $userInfo["password"])) {
                    if ($array["pass1"] == $array["pass2"]) {
                        if (mb_strlen($array["pass1"]) < 6) {
                            $array["errors"] .= 'Пароль не должен быть короче 6-ти символов</br>';    
                        } else {
                            $dataForUpdate = array("password" => password_hash($array["pass1"], PASSWORD_BCRYPT));
                            Common::updateRow($dataForUpdate, $userInfo['id']);
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
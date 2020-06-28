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
        $title = 'Личный кабинет';
        require_once(ROOT . '/views/cabinet/index.php');
        return true;
    }

    /**
     * Action для страницы "Редактирование данных пользователя"
     */
    public function actionEdit()
    {
        $userId = User::checkLogged();
        $user = User::getUserBy("id", $userId);
        $name = $user['name'];
        $password = $user['password'];
        $result = false;
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $password = $_POST['password'];
            $errors = false;
            if (!User::checkUsername($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            if ($errors == false) {
                $result = User::edit($userId, $name, $password);
            }
        }
        require_once(ROOT . '/views/cabinet/edit.php');
        return true;
    }

}

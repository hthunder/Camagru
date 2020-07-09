<?php

/**
 * Класс User - модель для работы с пользователями
 */
class User
{
    /**
     * Checks that a row with a given value in a column exists
     */
    public static function checkRowExists($fieldName, $fieldValue) {     
        $db = Db::getConnection();
        $sql = "SELECT COUNT(*) FROM users WHERE " . "$fieldName = :" . "$fieldName";
        $result = $db->prepare($sql);
        $result->bindParam(":$fieldName", $fieldValue, PDO::PARAM_STR);
        $result->execute();
        if ($result->fetchColumn())
            return true;
        return false;
    }

    /**
     * Checks that a form is filled out properly
     * and returns errors
     */
    public static function isRegistrationValid($data) {
        $errors = $data["errors"];
        if (mb_strlen($data['username']) < 2)
            $errors .= 'Имя не должно быть короче 2-х символов</br>';
        if (User::checkRowExists('username', $data['username']))
            $errors .= 'Такое имя пользователя уже используется</br>';
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            $errors .= 'Неправильный email</br>';
        if (User::checkRowExists('email', $data['email']))
            $errors .= 'Такой email уже используется</br>';
        if ($data['pass1'] == $data['pass2']) {
            if (mb_strlen($data['pass1']) < 6)
                $errors .= 'Пароль не должен быть короче 6-ти символов</br>';
        } else {
            $errors .= 'Пароли должны совпадать</br>';
        }
        return($errors);
    }

    /**
     * this function checks an input login and email for changing in cabinet
     */
    public static function changeInfoValidation(array $data) {
        $errors = $data["errors"];
        if (mb_strlen($data['username']) < 2)
            $errors .= 'Имя не должно быть короче 2-х символов</br>';
        $user = Common::getRowsBy("username", $data["username"], "users")->fetch();
        if ($user && $user["id"] !== $_SESSION["id"])
            $errors .= 'Такое имя пользователя уже используется</br>';
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            $errors .= 'Неправильный email</br>';
        $user = Common::getRowsBy("email", $data["email"], "users")->fetch();
        if ($user && $user["id"] !== $_SESSION["id"])
            $errors .= 'Такое имя пользователя уже используется</br>';
        return($errors);
    }

    /**
     * Checks that a user is activated
     */
    public static function isActivated($userId) {
        $db = Db::getConnection();
        $sql = 'SELECT COUNT(*) FROM users WHERE id = :id AND activation_status = 1';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $userId, PDO::PARAM_INT);
        $result->execute();
        return $result->fetchColumn() ? true : false;
    }

    /**
     * User login. 
     */
    public static function login(array $userData) {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM users WHERE (email = :email OR username = :username)';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $userData["email_username"], PDO::PARAM_STR);
        $result->bindParam(':username', $userData["email_username"], PDO::PARAM_STR);
        $result->execute();
        $user = $result->fetch();
        if ($user && password_verify($userData["password"], $user["password"])) {
            if (User::isActivated($user['id'])) {
                User::auth($user["id"], $user["username"], $user["notifications"]);
                header("Location: /cabinet");
                exit();
            } else {
                return ("Пользователь не активирован");
            }    
        } else {
            return ("Пользователь с такими данными не найден");
        }
    }

    /**
     * Saves a user in a session
     */
    public static function auth($userId, $username, $notifications) {
        $_SESSION["notifications"] = $notifications;
        $_SESSION["id"] = $userId;
        $_SESSION["username"] = $username;
    }

    /**
     * Returns an id of user if he is authorised else redirects to a login page
     */
    public static function checkLogged() {
        if (isset($_SESSION["id"]) && isset($_SESSION["notifications"]) && isset($_SESSION["username"])){
            return $_SESSION["id"];
        }
        header("Location: /user/login");
        exit();
    }

    /**
     * Отправить письмо с подтверждением на почту
     */
    public static function sendMail($email, $subject, $activation_code) {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: Nosov.yura.web@gmail.com\r\n";
        if ($subject === "Ссылка для восстановления пароля")
            $message = '<p>Чтобы восстановить пароль, перейдите по <a href="http://localhost/user/changePass/' . $activation_code . '">ссылке</a></p>';
        else
            $message = '<p>Чтобы подтвердить Email, перейдите по <a href="http://localhost/user/activation/' . $activation_code . '">ссылке</a></p>';
        mail($email, $subject, $message, $headers);
    }

    /**
     * Sends notifications about recieved comments
     */
    public static function sendNotification($email, $subject, $link, $text) {
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "From: Nosov.yura.web@gmail.com\r\n";

        $message = "<p>Под вашим фото оставили новый комментарий: $text. <a href=" . "$link" . ">Ссылка на фото</a></p>";
        mail($email, $subject, $message, $headers);
    }



    /**
     * User activation
     */

    public static function activation($activation_code) {
        $db = Db::getConnection();
        if ($activation_code) {
            $sql = 'SELECT id, activation_status FROM users WHERE activation_code = :activation_code';
            $result = $db->prepare($sql);
            $result->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
            if ($result->execute()) {
                $row = $result->fetch();
                    if ($row['activation_status'] == 0) {
                        if (Common::updateRow(array("activation_status" => 1), $row["id"]))
                            return ("Email подтвержден");
                    } else {
                        return ("Email уже подтвержден");
                    }
            } else {
                return ("Что-то пошло не так");
            }
        }
    }

    public static function notificationsToggle() {
		$db = Db::getConnection();
        $sql = 'UPDATE users SET notifications = ((notifications + 1) % 2) WHERE id = :id';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $_SESSION["id"], PDO::PARAM_INT);
		return($result->execute());
	}
}

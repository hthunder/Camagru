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
        if (strlen($data['username']) < 2)
            $errors .= 'Имя не должно быть короче 2-х символов</br>';
        if (User::checkRowExists('username', $data['username']))
            $errors .= 'Такое имя пользователя уже используется</br>';
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            $errors .= 'Неправильный email</br>';
        if (User::checkRowExists('email', $data['email']))
            $errors .= 'Такой email уже используется</br>';
        if ($data['pass1'] == $data['pass2']) {
            if (strlen($data['pass1']) < 6)
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
        if (strlen($data['username']) < 2)
            $errors .= 'Имя не должно быть короче 2-х символов</br>';
        $user = User::getUserBy("username", $data["username"]);
        if ($user && $user["id"] !== $_SESSION["user"])
            $errors .= 'Такое имя пользователя уже используется</br>';
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
            $errors .= 'Неправильный email</br>';
        $user = User::getUserBy("email", $data["email"]);
        if ($user && $user["id"] !== $_SESSION["user"])
            $errors .= 'Такое имя пользователя уже используется</br>';
        return($errors);
    }

    /**
     * This function lets to update user data
     */
    public static function updateUserData(array $userData, $id) {
        $db = Db::getConnection();
        $sql = "UPDATE users SET";
        foreach($userData as $key => $value) {
            $sql .= " $key = :$key,";
        }
        $sql = substr($sql, 0, -1);
        $sql .= " WHERE id =:id";
        $result = $db->prepare($sql);
        $userData["id"] = $id;
        $result->execute($userData);
        return true; 
    }

    /**
     * Registers a new user and adds him to a database
     */
    public static function register($username, $email, $password, $activation_code) {
        $db = Db::getConnection();
        $hashedPass = password_hash($password, PASSWORD_BCRYPT);
        $sql = 'INSERT INTO users (username, email, password, activation_code) '
                . 'VALUES (:username, :email, :password, :activation_code)';
        $result = $db->prepare($sql);
        $result->bindParam(':username', $username, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $hashedPass, PDO::PARAM_STR);
        $result->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
        return $result->execute();
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
                User::auth($user['id']);
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
    public static function auth($userId) {
        $_SESSION['user'] = $userId;
    }

    /**
     * Returns an id of user if he is authorised else redirects to a login page
     */
    public static function checkLogged() {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        header("Location: /user/login");
        exit();
    }

    /**
     * Retrieve user info by a given field
     * $field The field to retrieve the user with.
     * $value A value for $field
     */
    public static function getUserBy($field, $value) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM users WHERE " . "$field = :" . "$field";
        $result = $db->prepare($sql);
        if ($field == 'id' || $field == 'activation_status')
            $result->bindParam(":$field", $value, PDO::PARAM_INT);
        else
            $result->bindParam(":$field", $value, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
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
     * User activation
     */

    public static function activation($activation_code) {
        $db = Db::getConnection();
        if ($activation_code) {
            $sql = 'SELECT id, activation_status FROM users WHERE activation_code = :activation_code';
            $result = $db->prepare($sql);
            $result->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
            $result->execute();
            if ($result) {
                while($row = $result->fetch()) {
                    if ($row['activation_status'] == 0) {
                        $activation_status = 1;
                        $sql = 'UPDATE users SET activation_status = :activation_status WHERE id = :id';
                        $result = $db->prepare($sql);
                        $result->bindParam(':activation_status', $activation_status, PDO::PARAM_INT);
                        $result->bindParam(':id', $row['id'], PDO::PARAM_INT);
                        $result->execute();
                        return ("Email подтвержден");
                    } else {
                        return ("Email уже подтвержден");
                    }
                }    
            } else {
                return ("Что-то пошло не так");
            }
        }
    }
}

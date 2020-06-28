<?php

/**
 * Класс User - модель для работы с пользователями
 */
class User
{

    /**
     * Checks that a form is filled out properly
     * and returns errors
     */

    public static function isRegistrationValid($data) {
        $errors = $data["errors"];
        if (strlen($data['username']) < 2)
            $errors .= 'Имя не должно быть короче 2-х символов</br>';
        if (User::checkUsernameExists($data['username']))
            $errors .= 'Такое имя пользователя уже используется</br>';

        if (!User::checkEmail($data['email']))
            $errors .= 'Неправильный email</br>';
        if (User::checkEmailExists($data['email']))
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
     * A user registration
     */
    public static function register($username, $email, $password, $activation_code) {
        $db = Db::getConnection();
        $sql = 'INSERT INTO users (username, email, password, activation_code) '
                . 'VALUES (:username, :email, :password, :activation_code)';
        $result = $db->prepare($sql);
        $result->bindParam(':username', $username, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Edits user info
     */
    public static function edit($id, $username, $password) {
        $db = Db::getConnection();
        $sql = "UPDATE users SET username = :username, password = :password 
                WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':username', $username, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Checks that a user with a given email and password exists
     */
    public static function checkUserData($email_username, $password) {
        $db = Db::getConnection();
        $sql = 'SELECT id FROM users WHERE (email = :email OR username = :username) AND password = :password';
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email_username, PDO::PARAM_STR);
        $result->bindParam(':username', $email_username, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();
        $user = $result->fetch();
        if ($user) {
            $sql = 'SELECT COUNT(*) FROM users WHERE id = :id AND activation_status = :activation_status';
            $result = $db->prepare($sql);
            $activation_status = 1;
            $result->bindParam(':id', $user['id'], PDO::PARAM_INT);
            $result->bindParam(':activation_status', $activation_status, PDO::PARAM_INT);
            $result->execute();
            $isActivated = $result->fetch()['COUNT(*)'];
            if ($isActivated) {
                return $user['id'];
            } else {
                return (-2);
            }
        }
        return (-1);
    }

    /**
     * Saves a user in a session
     */
    public static function auth($userId) {
        // Записываем идентификатор пользователя в сессию
        $_SESSION['user'] = $userId;
    }

    /**
     * Returns an id of user if he is authorised else redirects to a login page
     */
    public static function checkLogged() {
        // Если сессия есть, вернем идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        header("Location: /user/login");
    }

    /**
     * Checks that a user is a guest
     */
    public static function isGuest() {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    /**
     * Checks that a username exists
     */
    public static function checkUsernameExists($username) {       
        $db = Db::getConnection();
        $sql = 'SELECT COUNT(*) FROM users WHERE username = :username';
        $result = $db->prepare($sql);
        $result->bindParam(':username', $username, PDO::PARAM_STR);
        $result->execute();
        if ($result->fetchColumn())
            return true;
        return false;
    }

    /**
     * Проверяет email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет не занят ли email другим пользователем
     * @param type $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmailExists($email) {
        // Соединение с БД        
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT COUNT(*) FROM users WHERE email = :email';

        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();
        if ($result->fetchColumn())
            return true;
        return false;
    }

    /**
     * Возвращает пользователя с указанным id
     * @param integer $id <p>id пользователя</p>
     * @return array <p>Массив с информацией о пользователе</p>
     */
    public static function getUserById($id) {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT * FROM users WHERE id = :id';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        // Указываем, что хотим получить данные в виде массива
        // $result->setFetchMode(PDO::FETCH_ASSOC);
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
        $message = '<p>Чтобы подтвердить Email, перейдите по <a href="http://localhost/user/activation/' . $activation_code . '">ссылке</a></p>';
        mail($email, $subject, $message, $headers);
    }

    /**
     * Активация пользователя
     */

    public static function activation($activation_code) {
        $db = Db::getConnection();
        if ($activation_code) {
            // Текст запроса к БД
            $sql = 'SELECT id, activation_status FROM users WHERE activation_code = :activation_code';

            // Получение результатов. Используется подготовленный запрос
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

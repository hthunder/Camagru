<?php

/**
 * Класс User - модель для работы с пользователями
 */
class User
{

    /**
     * Регистрация пользователя 
     * @param string $username <p>Имя</p>
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function register($username, $email, $password, $activation_code)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'INSERT INTO users (username, email, password, activation_code) '
                . 'VALUES (:username, :email, :password, :activation_code)';

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':username', $username, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Редактирование данных пользователя
     * @param integer $id <p>id пользователя</p>
     * @param string $username <p>Имя</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function edit($id, $username, $password)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = "UPDATE users 
            SET username = :username, password = :password 
            WHERE id = :id";

        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':username', $username, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        return $result->execute();
    }

    /**
     * Проверяем существует ли пользователь с заданными $email и $password
     * @param string $email <p>E-mail</p>
     * @param string $password <p>Пароль</p>
     * @return mixed : integer user id or false
     */
    public static function checkUserData($email_username, $password)
    {
        // Соединение с БД
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT * FROM users WHERE (email = :email OR username = :username) AND password = :password';

        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email_username, PDO::PARAM_STR);
        $result->bindParam(':username', $email_username, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();

        // Обращаемся к записи
        $user = $result->fetch();

        if ($user) {
            // Если запись существует, возвращаем id пользователя
            return $user['id'];
        }
        return false;
    }

    /**
     * Запоминаем пользователя
     * @param integer $userId <p>id пользователя</p>
     */
    public static function auth($userId)
    {
        // Записываем идентификатор пользователя в сессию
        $_SESSION['user'] = $userId;
    }

    /**
     * Возвращает идентификатор пользователя, если он авторизирован.<br/>
     * Иначе перенаправляет на страницу входа
     * @return string <p>Идентификатор пользователя</p>
     */
    public static function checkLogged()
    {
        // Если сессия есть, вернем идентификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    /**
     * Проверяет является ли пользователь гостем
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    /**
     * Проверяет имя: не меньше, чем 2 символа
     * @param string $username <p>Имя</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkUsername($username)
    {
        if (strlen($username) >= 2) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет не занят ли username другим пользователем
     * @param type $username <p>Username</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkUsernameExists($username)
    {
        // Соединение с БД        
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT COUNT(*) FROM users WHERE username = :username';
        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':username', $username, PDO::PARAM_STR);
        $result->execute();
        if ($result->fetchColumn())
            return true;
        return false;
    }


    /**
     * Проверяет телефон: не меньше, чем 10 символов
     * @param string $phone <p>Телефон</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkPhone($phone)
    {
        if (strlen($phone) >= 10) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет имя: не меньше, чем 6 символов
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    /**
     * Проверяет email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function checkEmail($email)
    {
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
    public static function checkEmailExists($email)
    {
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
    public static function getUserById($id)
    {
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
     * Получить все маски
     * @return array Возвращает массив путей
    */

    public static function getMasks()
    {
        $masks = scandir(ROOT . "/public/images/masks/");
        return $masks;
    }

    // public static function getUserPhoto() {

    // }

    // public static function createUserPhoto()
    // {
    //     // getPhoto();
    //     /*
    //     $base_image = imagecreatetruecolor(1000, 1000);

    //     imagealphablending($base_image, false);
    //     $col = imagecolorallocatealpha($base_image, 255, 255, 255, 127);
    //     imagefilledrectangle($base_image, 0, 0, 90, 135, $col);
    //     imagealphablending($base_image,true);
    //     imagesavealpha($base_image, true);
    //     $photo = imagecreatefromjpeg(ROOT . '/public/images/back.jpg');
    //     $top_image = imagecreatefrompng(ROOT . '/public/images/masks/heart.png');

    //     imagecopy($base_image, $photo, 20, 23, 0, 0, 1000, 1000);
    //     imagecopy($base_image, $top_image, 0, 0, 0, 0, 1000, 1000);
    //     */

    //     // create base image
    //     $photo = imagecreatefromjpeg(ROOT . "/public/images/work-copy.jpg");
    //     $frame = imagecreatefrompng(ROOT . "/public/images/masks/heart.png");

    //     // get frame dimentions
    //     $frame_width = imagesx($frame);
    //     $frame_height = imagesy($frame);

    //     // get photo dimentions
    //     $photo_width = imagesx($photo);
    //     $photo_height = imagesy($photo);

    //     // creating canvas of the same dimentions as of frame
    //     // $canvas = imagecreatetruecolor($frame_width,$frame_height);
    //     $canvas = imagecreatetruecolor($photo_width, $photo_height);

    //     // make $canvas transparent
    //     // imagealphablending($canvas, false);
    //     // $col = imagecolorallocatealpha($canvas,255,255,255,127);
    //     // imagefilledrectangle($canvas,0,0,$frame_width,$frame_height,$col);
    //     imagealphablending($canvas,true);    
    //     // imagesavealpha($canvas, true);

    //     // merge photo with frame and paste on canvas 
    //     imagecopy($canvas, $photo, 0, 0, 0, 0, $photo_width, $photo_height);
    //     imagecopy($canvas, $frame, 0, 0, 0, 0, $frame_width, $frame_height);
    //     // imagecopyresized($canvas, $frame, 0, 0, 0, 0, $photo_width, $photo_height, $frame_width, $frame_height); // resize png to fit in canvas

    //     // return file
    //     header('Content-Type: image/jpeg');
    //     imagejpeg($canvas);

    //     // destroy images to free alocated memory
    //     imagedestroy($photo);
    //     imagedestroy($frame);
    //     imagedestroy($canvas);


        
    //     // imagecopymergegray($dest, $src1, 0, 0, 100, 100, 1000, 1000, 100);
    //     header('Content-Type: image/png');
    //     // imagepng($base_image);
    //     // imagepng($src1);
    //     // imagejpeg($dest);
    //     // imagepng($dest);
    //     // imagejpeg($src);
    //     // imagedestroy($dest);
    //     // imagedestroy($src1);
    // }

}

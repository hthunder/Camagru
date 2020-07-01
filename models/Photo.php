<?php

class Photo {

    public static function getUniqueName($path, $extension)
    {
        $extension = '.' . $extension;
        do {
            $name = md5(microtime() . rand(0, 9999));
            $file = $path . $name . $extension;
        } while (file_exists($file));
        return $file;
    }

    public static function mergePhoto($image, $info)
    {
        $photo = $image;
        $reg_exp = "/\/(\w+.png)/";
        preg_match($reg_exp, $info->src, $matches);
        $frame = imagecreatefrompng(ROOT . "/public/images/masks/" . $matches[1]);
        $photo_width = imagesx($photo);
        $photo_height = imagesy($photo);
        $photo_windowWidth = explode("px", $info->windowWidth)[0];
        $photo_windowHeight = explode("px", $info->windowHeight)[0];
        $scaleX = $photo_width / $photo_windowWidth;
        $scaleY = $photo_height / $photo_windowHeight;
        $frame_width = explode("px", $info->width)[0];
        $frame_height = explode("px", $info->height)[0];
        $frame_left = explode("px", $info->left)[0];
        $frame_top = explode("px", $info->top)[0];
        $frame_left -= $frame_width / 2;
        $frame_left *= $scaleX;
        $frame_top *= $scaleY;
        $frame = imagescale($frame, $frame_width * $scaleX, $frame_height * $scaleY);
        $frame_width = imagesx($frame);
        $frame_height = imagesy($frame);

        imagealphablending($photo, true);
        imagecopy($photo, $frame, (int)$frame_left, (int)$frame_top, 0, 0, $frame_width, $frame_height);

        return $photo;
    }

    public static function photoCrop($img) {
        $width = imagesx($img);
        $height = imagesy($img);
        $aspectRatio = 4/3;
        if ($width > $height)
            $croppedImg = imagecrop($img, ['x' => 0, 'y' => 0, 'width' => $height, 'height' => $height * (1/$aspectRatio)]);
        else
            $croppedImg = imagecrop($img, ['x' => 0, 'y' => 0, 'width' => $width, 'height' => $width * (1/$aspectRatio)]);
        return($croppedImg);
    }

    public static function createPhoto($img, $info, $id)
    {
            list($type, $img) = explode(';', $img);
			list(, $img)      = explode(',', $img);
			/* Декодируем, принятое фото */
			$img = base64_decode($img);

            /* Создаем уникальное имя для хранения во временной папке и размещаем фото */
            if (!is_dir(ROOT . '/public/images/tmp_gallery'))
                mkdir(ROOT . '/public/images/tmp_gallery');
            $uniquePath = Photo::getUniqueName(ROOT . '/public/images/tmp_gallery/', 'jpg');
			file_put_contents($uniquePath, $img);

			/* Создаем изображение из файла и накладываем маску*/
            $image = imagecreatefromjpeg($uniquePath);
            

            if($info != null) {
                foreach($info as $infoPart) {
                    if ($infoPart->width != null && $infoPart->height != null 
                    && $infoPart->left != null && $infoPart->top != null)
                    $image = Photo::mergePhoto($image, $infoPart);      
                }
                  
            }
            $image = Photo::photoCrop($image);
            /* Размещаем фото в постоянной галерее */
            
            $pattern = '/tmp_gallery/';
            $replacement = 'gallery/' . $id;
            $finalPath = preg_replace($pattern, $replacement, $uniquePath);

            date_default_timezone_set('Europe/Moscow');
            if (!file_exists($finalPath)) {
                imagejpeg($image, $finalPath);
                $dateOfCreation = date('Y-m-d-H-i-s');
                $pieces = explode('/', $finalPath);
                $photo_src = array_pop($pieces);
                Photo::addPhotoToDb($id, $photo_src, $dateOfCreation);
			} else {
                $finalPath = Photo::getUniqueName(ROOT . '/public/images/gallery/' . $id . '/', 'jpg');
                imagejpeg($image, $finalPath);
                $dateOfCreation = date('Y-m-d-H-i-s');
                $pieces = explode('/', $finalPath);
                $photo_src = array_pop($pieces);
                Photo::addPhotoToDb($id, $photo_src, $dateOfCreation);
            }

			/* Удаляем файл из временной папки */
			unlink($uniquePath);
    }

    public static function addPhotoToDb($id, $photo_src, $dateOfCreation) {
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'INSERT INTO photos (photo_src, user_id, creation_date) VALUES (:photo_src, :user_id, :creation_date)';

        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':photo_src', $photo_src, PDO::PARAM_STR);
        $result->bindParam(':user_id', $id, PDO::PARAM_INT);
        $result->bindParam(':creation_date', $dateOfCreation, PDO::PARAM_STR);
        $result->execute();
    }

    /**
     * Получить все маски
     * @return array Возвращает массив путей
    */

    public static function getMasks() {
        $masks = scandir(ROOT . "/public/images/masks/");
        return $masks;
    }

    public static function getLastPhotos($id) {
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT photo_src FROM photos WHERE user_id = :user_id ORDER BY creation_date DESC LIMIT 6';

        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':user_id', $id, PDO::PARAM_INT);
        $result->execute();
        $photos = array();
        while($photo = $result->fetch()) {
            $photos[] = $photo['photo_src'];
        }
        return $photos;
    }

    public static function getAllPhotos() {
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT id, photo_src, user_id FROM photos ORDER BY creation_date DESC LIMIT 5';

        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        // $result->bindParam(':user_id', $id, PDO::PARAM_INT);
        $result->execute();
        $photos = array();
        while($row = $result->fetch()) {
            $photos[] = $row;
        }
        // var_dump($photos);
        // die();
        return $photos;
    }

    public static function showMore($minId) {
        $db = Db::getConnection();

        // Текст запроса к БД
        $sql = 'SELECT id, photo_src, user_id FROM photos WHERE id < :id ORDER BY creation_date DESC LIMIT 5';

        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $minId, PDO::PARAM_INT);
        $photos = array();
        if ($result->execute()) {
            while($row = $result->fetch()) {
                $photos[] = $row;
            }
        }
        return $photos;
    }

    public static function getIdByName($name) {
        $db = Db::getConnection();
        $photo_src1 = $name . '.jpeg';
        $photo_src2 = $name . '.jpg';

        // Текст запроса к БД
        $sql = 'SELECT id FROM photos WHERE (photo_src = :photo_src1) OR (photo_src = :photo_src2)';

        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':photo_src1', $photo_src1, PDO::PARAM_STR);
        $result->bindParam(':photo_src2', $photo_src2, PDO::PARAM_STR);
        if ($result->execute()) {
            return $result->fetch();
        } else {
            return false;
        }
    }
    
    public static function getComments($name) {
        $db = Db::getConnection();
        $photo_src1 = $name . '.jpeg';
        $photo_src2 = $name . '.jpg';
    
        // Текст запроса к БД
        $sql = 'SELECT text, username 
                FROM photos 
                JOIN comments ON photos.id = comments.photo_id 
                JOIN users ON users.id = comments.user_id 
                WHERE (photo_src = :photo_src1
                OR photo_src = :photo_src2)';
    
        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':photo_src1', $photo_src1, PDO::PARAM_STR);
        $result->bindParam(':photo_src2', $photo_src2, PDO::PARAM_STR);
        $comments = array();
        if ($result->execute()) {
            while ($row = $result->fetch()) {
                $comments[] = $row;
            }
        }
        return $comments;
    }

    public static function getLikesNumber($name) {
        $db = Db::getConnection();
        $src_name1 = $name . '.jpeg';
        $src_name2 = $name . '.jpg';
    
        // Текст запроса к БД
        $sql = 'SELECT likes FROM photos WHERE (photo_src = :src_name1
                OR photo_src = :src_name2)';
    
        // Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':src_name1', $src_name1, PDO::PARAM_STR);
        $result->bindParam(':src_name2', $src_name2, PDO::PARAM_STR);
        $likes = 0;
        if ($result->execute()) {
            if ($row = $result->fetch()) {
                $likes = $row['likes'];
            }
        }
        return $likes;
    }

    /**
     * getRowBy
     */
    public static function getRowBy($field, $value, $table) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM $table WHERE $field = :$field";
        $result = $db->prepare($sql);
        if ($field == 'id' || $field == 'activation_status')
            $result->bindParam(":$field", $value, PDO::PARAM_INT);
        else
            $result->bindParam(":$field", $value, PDO::PARAM_STR);
        $result->execute();
        return $result->fetch();
    }

    public static function deletePhoto($photoId, $photoOwnerId, $photoName) {

        Photo::deleteRowBy("id", $photoId, "photos");
        unlink(ROOT . "/public/images/gallery/$photoOwnerId/$photoName");
        header("Location: /photo/gallery");
        exit();
    }

    public static function deleteRowBy($field, $value, $table) {
        $db = Db::getConnection();
        $sql = "DELETE FROM $table WHERE $field = :$field";
        $result = $db->prepare($sql);
        if ($field == 'id' || $field == 'activation_status')
            $result->bindParam(":$field", $value, PDO::PARAM_INT);
        else
            $result->bindParam(":$field", $value, PDO::PARAM_STR);
        return($result->execute());
    }
}
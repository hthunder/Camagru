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

    public static function createPhoto($img, $info, $id)
    {
            list($type, $img) = explode(';', $img);
			list(, $img)      = explode(',', $img);
			/* Декодируем, принятое фото */
			$img = base64_decode($img);

			/* Создаем уникальное имя для хранения во временной папке и размещаем фото */
            $uniquePath = Photo::getUniqueName(ROOT . '/public/images/tmp_gallery/', 'jpg');
			file_put_contents($uniquePath, $img);

			/* Создаем изображение из файла и накладываем маску*/
            $image = imagecreatefromjpeg($uniquePath);
            if($info != null && $info->width != null && $info->height != null 
            && $info->left != null && $info->top != null) {
                $image = Photo::mergePhoto($image, $info);    
            }
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
        $photos_ids = array();
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
        $result->execute();
        $photos_ids = array();
        while($row = $result->fetch()) {
            $photos[] = $row;
        }
        // var_dump($photos);
        // die();
        return $photos;
    }
}
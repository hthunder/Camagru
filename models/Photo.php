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

    public static function createPhoto($img, $info)
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
            if($info->width != null && $info->height != null && $info->left != null && $info->top != null) {
                $image = Photo::mergePhoto($image, $info);    
            }

			/* Размещаем фото в постоянной галерее */
			$finalPath = preg_replace("/tmp_gallery/", "gallery", $uniquePath);
			if (!file_exists($finalPath)) {
                imagejpeg($image, $finalPath);	
			} else {
                imagejpeg($image, Photo::getUniqueName(ROOT . '/public/images/gallery/', 'jpg'));
            }

			/* Удаляем файл из временной папки */
			unlink($uniquePath);
    }
}
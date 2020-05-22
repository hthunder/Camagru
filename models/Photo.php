<?php

class Photo {

    public static function getUniqueName($path, $extension)
    {
        $extension = '.' . $extension;
        $path = $path . '/';
        do {
            $name = md5(microtime() . rand(0, 9999));
            $file = $path . $name . $extension;
        } while (file_exists($file));
        return $file;
    }

	// public static function createPhoto($name, $size, $type, $tmp_name, $error)
    // {

	// 	copy($tmp_name, ROOT . '/public/images/gallery' . basename($name));
    //     return true;
    // }
}
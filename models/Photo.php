<?php

class Photo {
	public static function createPhoto($name, $size, $type, $tmp_name, $error)
    {
		copy($tmp_name, ROOT . '/public/images/gallery' . basename($name));
        return true;
    }
}
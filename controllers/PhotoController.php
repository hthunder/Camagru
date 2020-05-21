<?php

/**
 * Контроллер PhotoController
 */
class PhotoController
{
	public function actionCreate()
	{
		/**
		 * 
		 * Сделать генерацию названий файлов
		 * 
		 * 
		 */
		$pieces = explode("/", $_FILES['uploadfile']['type']);
		if ($pieces[1] != "jpeg") {
			$_SESSION['errors'] = "Фото должно быть в формате jpeg";
			header("Location: /Camagru/user/photo");
			return false;
		} else {
			copy($_FILES['uploadfile']['tmp_name'], ROOT . '/public/images/gallery/' . basename($_FILES['uploadfile']['name']));
			$title = 'Сделать фото';
			require_once(ROOT . '/views/user/photo.php');
			header("Location: /Camagru/user/photo");
			return true;
		}
		// Photo::createPhoto($_FILES['uploadfile']['name'], $_FILES['uploadfile']['size'], $_FILES['uploadfile']['type'], 
		// $_FILES['uploadfile']['tmp_name'], $_FILES['uploadfile']['error']);
		
	}
}
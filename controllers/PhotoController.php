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
		 * Сделать генерацию названий файлов \/
		 * Сделать обработку масок \/
		 * Добавить отображение фото при ручном добавлении на фронте
		 * 
		 */
		if (isset($_POST['hidden'])) {
			$img = $_POST['hidden'];
			$info = $_POST['info'];
			$info = json_decode($info);
			Photo::createPhoto($img, $info);
			header("Location: /Camagru/user/photo");
			return true;
		} else {
			$pieces = explode("/", $_FILES['uploadfile']['type']);
			if ($pieces[1] != "jpeg") {
				$_SESSION['errors'] = "Фото должно быть в формате jpeg";
				header("Location: /Camagru/user/photo");
				return false;
			} else {
				copy($_FILES['uploadfile']['tmp_name'], Photo::getUniqueName(ROOT . '/public/images/gallery/', 'jpg'));
				$title = 'Сделать фото';
				header("Location: /Camagru/user/photo");
				return true;
			}	
		}
	}
}
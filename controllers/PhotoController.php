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
		}
	}
}
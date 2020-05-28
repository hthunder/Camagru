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
			$id = $_SESSION['user'];
			$path = ROOT . '/public/images/gallery/' . $id;
			if (!file_exists($path)) {
				mkdir($path);	
			}
			Photo::createPhoto($img, $info, $id);
			// Photo::addToDb();
			header("Location: /Camagru/photo/make");
			return true;
		}
	}
	
	public function actionMake()
    {
		$title = 'Сделать фото';
		$id = $_SESSION['user'];
		$masks = Photo::getMasks();
		$lastPhotos = Photo::getLastPhotos($id);
        require_once(ROOT . '/views/photo/make.php');
        return true;
    }

	public function actionGallery() {
		$title = 'Галерея';
		$photos = Photo::getAllPhotos();
		$minId = NULL;
		require_once(ROOT . '/views/photo/gallery.php');
		return true;
	}

	public function actionShowMore() {
		$minId = $_POST['id'];
		$photos = Photo::showMore($minId);
		header('Content-Type: application/json');
		echo json_encode($photos);
		return true;
	}
}
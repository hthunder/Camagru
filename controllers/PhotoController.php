<?php

/**
 * Контроллер PhotoController
 */
class PhotoController
{
	public function actionCreate()
	{
		User::checkLogged();
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
			header("Location: /photo/make");
			return true;
		}
	}
	
	public function actionMake()
    {
		User::checkLogged();
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
		if (isset($_POST['id'])) {
			$minId = $_POST['id'];
			$photos = Photo::showMore($minId);
			header('Content-Type: application/json');
			echo json_encode($photos);
			return true;	
		}
		return false;
		header("Location: ");
	}

	public function actionPage($photoOwnerId, $name) {
		$comments = Photo::getComments($name);
		$guestId = $_SESSION['user'];
		//Запрашиваем количество лайков, для фото с названием $name;
		$likesNumber = Photo::getLikesNumber($name); 
		$photoId = Photo::getIdByName($name)['id'];
		$isLiked = Like::isLiked($photoId, $guestId);
		$title = "Страница фотографии";
		require_once(ROOT . '/views/photo/page.php');
		return true;
	}
}
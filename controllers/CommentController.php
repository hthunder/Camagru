<?php

/**
 * Контроллер CommentController
 */
class CommentController
{	
	public function actionAdd()
    {
		// $title = 'Сделать фото';
		$comment = $_POST['comment'];
		$userId = $_SESSION['user']; // id того кто оставил фото
		$photoOwnerId = $_POST['photoOwner'];
		$photoName = $_POST['photo_name'];
		date_default_timezone_set('Europe/Moscow');
		$dateOfCreation = date('Y-m-d-H-i-s');
		$temp = Photo::getIdByName($photoName);
		$photoId = $temp['id'];
		// var_dump($photoId);
		// die();
		if (strlen($comment) <= 50 && strlen($comment) > 0)
			Comment::add($comment, $userId, $dateOfCreation, $photoId);
		header("Location: /Camagru/photo/page/" . $photoOwnerId . "/" . $photoName);
		// $masks = Photo::getMasks();
		// $lastPhotos = Photo::getLastPhotos($id);
        // require_once(ROOT . '/views/photo/make.php');
        return true;
    }
}
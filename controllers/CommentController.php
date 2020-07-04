<?php

/**
 * Контроллер CommentController
 */
class CommentController
{	
	public function actionAdd()
    {
		$comment = substr($_POST['comment'], 0, 45);
		$userId = $_SESSION['user']; // id того кто оставил фото
		$photoOwnerId = $_POST['photoOwner'];
		$photoName = $_POST['photo_name'];

		date_default_timezone_set('Europe/Moscow');
		$dateOfCreation = date('Y-m-d-H-i-s');
		$temp = Photo::getIdByName($photoName);
		if (!$temp) {
			header("Location: /photo/gallery");
			exit();
		}
		$photoId = $temp['id'];
		if (strlen($comment) <= 45 && strlen($comment) > 0)
			Common::insertRow(array("text" => $comment, "user_id" => $userId,
			"creation_date" => $dateOfCreation, "photo_id" => $photoId), "comments");
		header("Location: /photo/page/" . $photoOwnerId . "/" . $photoName);
        return true;
    }
}
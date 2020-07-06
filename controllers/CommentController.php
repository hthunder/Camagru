<?php

/**
 * Контроллер CommentController
 */
class CommentController
{	
	public function actionAdd()
    {
		$comment = mb_substr($_POST["comment"], 0, 45, 'UTF-8');
		$userId = $_SESSION['user']; // id того кто оставил фото
		$photoOwnerId = $_POST['photoOwner'];
		$photoName = $_POST['photo_name'];

		date_default_timezone_set('Europe/Moscow');
		$dateOfCreation = date('Y-m-d-H-i-s');
		$temp = Photo::getPhotoByName($photoName);
		if (!$temp) {
			header("Location: /photo/gallery");
			exit();
		}
		$photoId = $temp['id'];
		if (mb_strlen($comment) <= 45 && mb_strlen($comment) > 0) {
			if (Common::insertRow(array("text" => $comment, "user_id" => $userId,
			"creation_date" => $dateOfCreation, "photo_id" => $photoId), "comments")) {
				$res = Common::getRowsBy("id", $photoOwnerId, "users")->fetch();
				if ($res && $res["notifications"] == 1) {
					$link = "http://localhost/photo/page/$photoOwnerId/$photoName";
					User::sendNotification($res["email"], "Новый комментарий", $link, htmlspecialchars($comment));
				}
			}
		}
			
		header("Location: /photo/page/" . $photoOwnerId . "/" . $photoName);
        return true;
    }
}
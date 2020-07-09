<?php

/**
 * Контроллер CommentController
 */
class CommentController
{	
	public function actionAdd()
    {
		User::checkLogged();
		
		if (!empty($_POST["comment"]) && !empty($_POST["photoOwner"]) 
			&& !empty($_POST["photoName"])) {
			$comment = mb_substr($_POST["comment"], 0, 45, 'UTF-8');
			$userId = $_SESSION["id"]; // id того кто оставил фото
			$photoOwnerId = $_POST['photoOwner'];
			$photoName = $_POST['photoName'];

			date_default_timezone_set('Europe/Moscow');
			$dateOfCreation = date('Y-m-d-H-i-s');
			$temp = Photo::getPhotoByName($photoName);
			if (!$temp) {
				header("Location: /photo/gallery");
				exit();
			}
			$photoId = $temp['id'];
			if (mb_strlen($comment) <= 45 && mb_strlen($comment) > 0) {
				if ($lastInserted = Common::insertRowGetLast(array("text" => $comment, "user_id" => $userId,
				"creation_date" => $dateOfCreation, "photo_id" => $photoId), "comments")) {
					$res = Common::getRowsBy("id", $photoOwnerId, "users")->fetch();
					if ($res && $res["notifications"] == 1) {
						$link = "http://localhost/photo/page/$photoOwnerId/$photoName";
						User::sendNotification($res["email"], "Новый комментарий", $link, htmlspecialchars($comment));
					}
					echo(json_encode($lastInserted));
				}
			}
		}
        return true;
	}
	
	public function actionDelete()
	{
		User::checkLogged();
		if (!empty($_POST["commentId"]))
			echo(Comment::deleteComment($_POST["commentId"])? "true" : "false");
		return true;
	}
}
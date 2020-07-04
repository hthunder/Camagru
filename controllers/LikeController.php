<?php

/**
 * Контроллер LikeController
 */
class LikeController
{
	public function actionAddRemove() {
		if (isset($_POST['like'])) {
			$like = $_POST['like']; // Ставим или снимаем (true or false)
			$whoseLike = $_SESSION['user'];
			$photoName = $_POST['photoName'];
			$temp = Photo::getIdByName($photoName);
			if (!$temp) {
				exit();
			}
			$photoId = $temp["id"];
			Like::likeToPhoto($photoId, $like);
			if ($like) 
				Common::insertRow(array("photo_id" => $photoId, "user_id" => $whoseLike), "likes");
			else
				Common::deleteRowsBy("photo_id", $photoId, "likes");
			header('Content-Type: application/json');
			echo json_encode(['response' => 'good']);
			return true;	
		}
		header("Location: /");
		return false;
	}
}
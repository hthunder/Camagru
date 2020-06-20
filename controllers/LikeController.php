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
			$photoId = Photo::getIdByName($photoName)['id'];
			Like::likeToPhoto($photoId, $like);
			Like::likeToLikesDb($photoId, $whoseLike, $like);

			header('Content-Type: application/json');
			echo json_encode(['response' => 'good']);
			return true;	
		}
		header("Location: ");
		return false;
	}
}
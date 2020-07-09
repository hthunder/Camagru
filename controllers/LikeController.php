<?php

/**
 * Контроллер LikeController
 */
class LikeController
{
	public function actionAddRemove() {
		if (!empty($_POST["like"]) && !empty($_POST["photoId"]) && !empty($_SESSION["id"])) {
			$like = $_POST['like']; // Ставим или снимаем (true or false)
			$whoseLike = $_SESSION["id"];
			$photoId = $_POST["photoId"];

			if ($like === "true" && Like::isLiked($photoId, $whoseLike)) {
				header('Content-Type: application/json');
				echo json_encode(['response' => "bad"]);
				return true;
			} else if ($like === "true") {
				Like::likeToPhoto($photoId, $like);
				Common::insertRow(array("photo_id" => $photoId, "user_id" => $whoseLike), "likes");
			} else {
				Like::likeToPhoto($photoId, $like);
				Common::deleteRowsBy("photo_id", $photoId, "likes");
			}
			header('Content-Type: application/json');
			echo json_encode(['response' => 'good']);
			return true;	
		}
		header("Location: /");
		return false;
	}
}
<?php

class Like {

    public static function likeToPhoto($photoId, $like) {
		$db = Db::getConnection();
		// $photo_src1 = $photoName . '.jpg';
		// $photo_src2 = $photoName . '.jpeg';

		//Текст запроса к БД
		if ($like == 'true')
        	$sql = 'UPDATE photos SET likes = likes + 1 WHERE id = :photoId';
		else
			$sql = 'UPDATE photos SET likes = likes - 1 WHERE id = :photoId';
        //Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':photoId', $photoId, PDO::PARAM_INT);
        // $result->bindParam(':photo_src2', $photo_src2, PDO::PARAM_STR);
		if ($result->execute())
			return true;
		return false;
	}

	public static function likeToLikesDb($photoId, $whoseLike, $like) {
		$db = Db::getConnection();

		//Текст запроса к БД
		if ($like == 'true')
        	$sql = 'INSERT INTO likes (photo_id, user_id) VALUES (:photo_id, :user_id)';
		else
			$sql = 'DELETE FROM likes WHERE (photo_id = :photo_id)';
        //Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
		$result->bindParam(':photo_id', $photoId, PDO::PARAM_INT);
		if ($like == 'true')
        	$result->bindParam(':user_id', $whoseLike, PDO::PARAM_INT);
		if ($result->execute())
			return true;
		return false;
	}

	public static function isLiked($photoId, $guestId) {
		$db = Db::getConnection();

		//Текст запроса к БД
        $sql = 'SELECT COUNT(*) FROM likes WHERE (user_id = :user_id AND photo_id = :photo_id)';
        //Получение результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
		$result->bindParam(':user_id', $guestId, PDO::PARAM_INT);
		$result->bindParam(':photo_id', $photoId, PDO::PARAM_INT);
		if ($result->execute())
			return $result->fetchColumn();
		return null;
	}
}
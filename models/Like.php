<?php

class Like {
    public static function likeToPhoto($photoId, $like) {
		$db = Db::getConnection();
		
		if ($like == 'true')
        	$sql = 'UPDATE photos SET likes = likes + 1 WHERE id = :photoId';
		else
			$sql = 'UPDATE photos SET likes = likes - 1 WHERE id = :photoId';
        $result = $db->prepare($sql);
        $result->bindParam(':photoId', $photoId, PDO::PARAM_INT);
		if ($result->execute())
			return true;
		return false;
	}

	public static function isLiked($photoId, $guestId) {
		$db = Db::getConnection();

        $sql = 'SELECT COUNT(*) FROM likes WHERE (user_id = :user_id AND photo_id = :photo_id)';
        $result = $db->prepare($sql);
		$result->bindParam(':user_id', $guestId, PDO::PARAM_INT);
		$result->bindParam(':photo_id', $photoId, PDO::PARAM_INT);
		if ($result->execute())
			return $result->fetchColumn();
		return null;
	}
}
<?php

// class Comment {

//     public static function add($comment, $userId, $dateOfCreation, $photoId)
//     {
// 		$db = Db::getConnection();
//         // Текст запроса к БД
//         $sql = "INSERT INTO comments (text, photo_id, user_id, creation_date) VALUES (:text, :photo_id, :user_id, :creation_date)";

//         // Получение результатов. Используется подготовленный запрос
//         $result = $db->prepare($sql);
//         $result->bindParam(':text', $comment, PDO::PARAM_STR);
//         $result->bindParam(':photo_id', $photoId, PDO::PARAM_INT);
// 		$result->bindParam(':user_id', $userId, PDO::PARAM_INT);
// 		$result->bindParam(':creation_date', $dateOfCreation, PDO::PARAM_STR);
//         $result->execute();
// 	}
// }
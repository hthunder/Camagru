<?php

class Comment {
    public static function deleteComment($commentId) {
        $db = Db::getConnection();
        $sql = "DELETE FROM comments WHERE (id = :id && user_id = :user_id)";
        $result = $db->prepare($sql);
        $result->execute(array("id" => $commentId, "user_id" => $_SESSION["id"]));
        return($result->rowCount());
    }
}
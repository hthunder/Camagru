<?php

class Common {
    public static function getRowsBy($field, $value, $table) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM $table WHERE $field = :$field";
        $result = $db->prepare($sql);
        if ($field == 'id' || $field == 'activation_status')
            $result->bindParam(":$field", $value, PDO::PARAM_INT);
        else
            $result->bindParam(":$field", $value, PDO::PARAM_STR);
        if ($result->execute())
            return($result);
        else
            return(false);
    }

    public static function deleteRowsBy($field, $value, $table) {
        $db = Db::getConnection();
        $sql = "DELETE FROM $table WHERE $field = :$field";
        $result = $db->prepare($sql);
        if ($field == 'id' || $field == 'activation_status')
            $result->bindParam(":$field", $value, PDO::PARAM_INT);
        else
            $result->bindParam(":$field", $value, PDO::PARAM_STR);
        return($result->execute());
    }

    public static function insertRow(array $userData, $table) {
        $db = Db::getConnection();
        $sql = "INSERT INTO $table (";
        foreach ($userData as $key => $value)
            $sql .= "$key, ";
        $sql = substr($sql, 0, -2);
        $sql .= ") VALUES (";
        foreach ($userData as $key => $value)
            $sql .= ":$key, ";
        $sql = substr($sql, 0, -2);
        $sql .= ")";

        $result = $db->prepare($sql);
        return($result->execute($userData));
    }

    public static function updateRow(array $userData, $id) {
        $db = Db::getConnection();
        $sql = "UPDATE users SET";
        foreach($userData as $key => $value) {
            $sql .= " $key = :$key,";
        }
        $sql = substr($sql, 0, -1);
        $sql .= " WHERE id =:id";
        $result = $db->prepare($sql);
        $userData["id"] = $id;
        return ($result->execute($userData));
    }
}
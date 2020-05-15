<?php

class Db
{
	public static function getConnection()
	{
		require(ROOT . '/config/database.php');
		try {
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			return $db;
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}
}
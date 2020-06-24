<?php

class Db
{
	public static function getConnection()
	{
		require(ROOT . '/config/database.php');
		$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
		return $db;
	}
}
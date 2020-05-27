<?php
	function createUsersTable($db) {
		$sql = "CREATE TABLE IF NOT EXISTS users(
    		id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
			username  VARCHAR(30) NOT NULL UNIQUE,
			email VARCHAR(30) NOT NULL UNIQUE,
			password VARCHAR(60) NOT NULL,
			activation_status BOOLEAN NOT NULL DEFAULT '0',
			activation_code VARCHAR(300) NOT NULL UNIQUE,
			notifications BOOLEAN NOT NULL DEFAULT '1',
			avatar_src VARCHAR(45) NULL)ENGINE=INNODB";
			$db->query($sql);
			// echo("Hi");
			// $pdo->exec($table);
			// $sql = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE user = 'admin'");
			// $sql->execute();
			// $admin_exists = $sql->fetchColumn();
			// $password = password_hash("admin", PASSWORD_BCRYPT);
			// if ($admin_exists == false)
			// {
			// 	$newstringintable = "INSERT INTO  Users (user, email, password, accepted_email, token, notifications) VALUES ('admin','admin@admin', '$password', true, '0', true)";
			// 	$pdo->exec($newstringintable);
			// }
	}

	function create_db() {
		require('../config/database.php');
		try {
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			createUsersTable($db);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	} 

	create_db();
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
	}

	function createPhotoTable($db) {
		$sql = "CREATE TABLE IF NOT EXISTS photos (
			id INT NOT NULL AUTO_INCREMENT,
			photo_src VARCHAR(45) NOT NULL,
			user_id INT NOT NULL,
			creation_date DATETIME NOT NULL,
			likes INT NULL,
			description VARCHAR(45) NULL,
			PRIMARY KEY (id),
			FOREIGN KEY (user_id) REFERENCES users(id)
			ON DELETE CASCADE
			ON UPDATE CASCADE)ENGINE = InnoDB";
		$db->query($sql);
	}

	function createCommentsTable($db) {
		$sql = "CREATE TABLE IF NOT EXISTS comments (
			id INT NOT NULL AUTO_INCREMENT,
			text VARCHAR(45) NOT NULL,
			photo_id INT NOT NULL,
			user_id INT NOT NULL,
			creation_date DATETIME NOT NULL,
			PRIMARY KEY (id),
			FOREIGN KEY (photo_id) 
				REFERENCES photos(id)
				ON DELETE CASCADE
				ON UPDATE CASCADE,
			FOREIGN KEY (user_id)
				REFERENCES users(id)
				ON DELETE CASCADE
				ON UPDATE CASCADE
		)ENGINE = InnoDB";
		$db->query($sql);
	}

	function createLikesTable($db) {
		$sql = "CREATE TABLE IF NOT EXISTS likes (
			photo_id INT NOT NULL,
			user_id INT NOT NULL,
			PRIMARY KEY (user_id, photo_id),
			FOREIGN KEY (user_id)
				REFERENCES users(id)
				ON DELETE CASCADE
				ON UPDATE CASCADE,
			FOREIGN KEY (photo_id)
				REFERENCES photos(id)
				ON DELETE CASCADE
				ON UPDATE CASCADE
		)ENGINE = InnoDB";
		$db->query($sql);
	}

	function create_db() {
		require('../config/database.php');
		try {
			$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			createUsersTable($db);
			createPhotoTable($db);
			createCommentsTable($db);
			createLikesTable($db);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	} 

	create_db();
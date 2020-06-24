<?php

// Параметры подключения к базе данных

$DB_DSN = 'mysql:dbname=Camagru;host=localhost;charset=utf8mb4';
$DB_DSN_SETUP = 'mysql:host=localhost;charset=utf8mb4';
$DB_USER = 'root';
$DB_PASSWORD = '';
$DB_OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
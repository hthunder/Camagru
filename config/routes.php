<?php

return array(
	'Camagru/user/register' => 'user/register',
	'Camagru/user/login' => 'user/login',
	// 'Camagru/user/photo' => 'user/photo',
	'Camagru/photo/make' => 'photo/make',
	'Camagru/photo/gallery' => 'photo/gallery',
	'Camagru/photo/showMore' => 'photo/showMore',
	'Camagru/user/activation/(\w+)' => 'user/activation/$1',
	'Camagru/photo/create' => 'photo/create',
	'Camagru/site/gallery' => 'site/gallery',
	'Camagru/cabinet' => 'cabinet/index',
	'Camagru' => 'site/index',
	'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2',
);
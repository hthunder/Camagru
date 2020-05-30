<?php

return array(
	'Camagru/user/register' => 'user/register',
	'Camagru/user/login' => 'user/login',
	'Camagru/user/activation/(\w+)' => 'user/activation/$1',
	'Camagru/photo/make' => 'photo/make',
	'Camagru/photo/gallery' => 'photo/gallery',
	'Camagru/photo/showMore' => 'photo/showMore',
	'Camagru/photo/page/(\d+)/(\w+)' => 'photo/page/$1/$2',
	'Camagru/photo/create' => 'photo/create',
	'Camagru/comment/add' => 'comment/add',
	'Camagru/like/addRemove' => 'like/addRemove',
	'Camagru/site/gallery' => 'site/gallery',
	'Camagru/cabinet' => 'cabinet/index',
	'Camagru' => 'site/index',
	'news/([a-z]+)/([0-9]+)' => 'news/view/$1/$2',
);
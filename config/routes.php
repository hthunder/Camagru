<?php

return array(
	'user/register' => 'user/register',
	'user/login' => 'user/login',
	'user/activation/(\w+)' => 'user/activation/$1',
	'photo/make' => 'photo/make',
	'photo/gallery' => 'photo/gallery',
	'photo/showMore' => 'photo/showMore',
	'photo/page/(\d+)/(\w+)' => 'photo/page/$1/$2',
	'photo/create' => 'photo/create',
	'comment/add' => 'comment/add',
	'like/addRemove' => 'like/addRemove',
	'site/gallery' => 'site/gallery',
	'cabinet' => 'cabinet/index',
	'' => 'site/index',
);
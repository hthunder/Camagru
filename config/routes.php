<?php

return array(
	'user/register' => 'user/register',
	'user/login' => 'user/login',
	'user/logout' => 'user/logout',
	'user/forgotPass' => 'user/forgotPass',
	'user/changePass' => 'user/changePass',
	'user/activation/(\w+)' => 'user/activation/$1',
	'user/notifications' => 'user/notifications',
	'photo/make' => 'photo/make',
	'photo/gallery' => 'photo/gallery',
	'photo/showMore' => 'photo/showMore',
	'photo/page/(\d+)/(\w+)' => 'photo/page/$1/$2',
	'photo/create' => 'photo/create',
	'photo/delete' => 'photo/delete',
	'comment/add' => 'comment/add',
	'like/addRemove' => 'like/addRemove',
	'site/gallery' => 'site/gallery',
	'cabinet/changeInfo' => 'cabinet/changeInfo',
	'cabinet/changePass' => 'cabinet/changePass',
	'cabinet' => 'cabinet/index',
	'' => 'site/index',
);
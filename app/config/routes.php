<?php
/**
*	Файл в якому можна прописати свої роути
*/

return [
	'registration' => 'registration/index',
	//'user/([0-9]+)' => 'user/view/$1',
	'auth' => 'registration/login',
	'login' => 'main/login',
	'dashboard' => 'dashboard/index',
	'dashboard/add' => 'dashboard/add',
	'/' => 'main/index', 
];
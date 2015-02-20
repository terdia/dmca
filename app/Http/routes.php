<?php

/*
 * Register Home Controller
*/

Route::get('/', 'PagesController@home');

/*
 * Register Notices Route Resource
*/

Route::get('notices/create/confirm', 'NoticesController@confirm');
Route::resource('notices', 'NoticesController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

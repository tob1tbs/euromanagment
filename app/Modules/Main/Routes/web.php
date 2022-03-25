<?php

// GENERAL ROUTES
Route::group(['prefix' => '/', 'middleware' => ['login']], function () {
	Route::get('/', 'MainController@actionMainIndex')->name('actionMainIndex');
});
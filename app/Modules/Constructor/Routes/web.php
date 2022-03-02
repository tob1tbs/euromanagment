<?php

// GENERAL ROUTES
Route::group(['prefix' => 'constructors', 'middleware' => []], function () {
    Route::get('/', 'actionConstructorController@ConstructorIndex')->name('actionConstructorIndex');
});

// AJAX ROUTES
Route::group(['prefix' => 'constructors/ajax', 'middleware' => []], function () {
    
});
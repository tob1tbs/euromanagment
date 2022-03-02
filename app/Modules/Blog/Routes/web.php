<?php

// GENERAL ROUTES
Route::group(['prefix' => 'blogs', 'middleware' => []], function () {
    Route::get('/', 'actionBlogController@BlogIndex')->name('actionBlogIndex');
});

// AJAX ROUTES
Route::group(['prefix' => 'blogs/ajax', 'middleware' => []], function () {
    
});
<?php

// GENERAL ROUTES
Route::group(['prefix' => 'services', 'middleware' => []], function () {
    Route::get('/', 'actionServicesController@ServicesIndex')->name('actionServicesIndex');
});

// AJAX ROUTES
Route::group(['prefix' => 'services/ajax', 'middleware' => []], function () {
    
});
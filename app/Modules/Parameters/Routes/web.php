<?php

// GENERAL ROUTES
Route::group(['prefix' => 'parameters', 'middleware' => []], function () {
    Route::get('/', 'ParametersController@actionParametersIndex')->name('actionParametersIndex');
});

// AJAX ROUTES
Route::group(['prefix' => 'parameters/ajax', 'middleware' => []], function () {
    
});
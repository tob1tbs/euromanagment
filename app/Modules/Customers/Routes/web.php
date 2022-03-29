<?php

// GENERAL ROUTES
Route::group(['prefix' => 'customers', 'middleware' => []], function () {
    Route::get('/', 'CustomersController@actionCustomersIndex')->name('actionCustomersIndex');
});

// AJAX ROUTES
Route::group(['prefix' => 'customers/ajax', 'middleware' => []], function () {
    
});
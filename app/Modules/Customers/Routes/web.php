<?php

// GENERAL ROUTES
Route::group(['prefix' => 'customers', 'middleware' => []], function () {
    Route::get('/', 'CustomersController@actionCustomersIndex')->name('actionCustomersIndex');
    Route::get('/add', 'CustomersController@actionCustomersAdd')->name('actionCustomersAdd');
});

// AJAX ROUTES
Route::group(['prefix' => 'customers/ajax', 'middleware' => []], function () {
    
});
<?php

// GENERAL ROUTES
Route::group(['prefix' => 'orders', 'middleware' => []], function () {
    Route::get('/', 'OrdersController@actionOrdersIndex')->name('actionOrdersIndex');
});

// AJAX ROUTES
Route::group(['prefix' => 'orders/ajax', 'middleware' => []], function () {
    
});
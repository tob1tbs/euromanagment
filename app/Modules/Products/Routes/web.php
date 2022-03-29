<?php

// GENERAL ROUTES
Route::group(['prefix' => 'products', 'middleware' => []], function () {
    Route::get('/', 'ProductsController@actionProductsIndex')->name('actionProductsIndex');
});

// AJAX ROUTES
Route::group(['prefix' => 'products/ajax', 'middleware' => []], function () {
    
});
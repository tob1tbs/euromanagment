<?php

// GENERAL ROUTES
Route::group(['prefix' => 'products', 'middleware' => []], function () {
    Route::get('/', 'ProductsController@actionProductsIndex')->name('actionProductsIndex');
    Route::get('/add', 'ProductsController@actionProductsAdd')->name('actionProductsAdd');
    Route::get('/categories', 'ProductsController@actionProductCategory')->name('actionProductCategory');
    Route::get('/vendors', 'ProductsController@actionProductVendor')->name('actionProductVendor');
    Route::get('/brands', 'ProductsController@actionUsersBrands')->name('actionUsersBrands');
    Route::get('/balance', 'ProductsController@actionProductBalance')->name('actionProductBalance');
    Route::get('/balance/history', 'ProductsController@actionProductBalanceHistory')->name('actionProductBalanceHistory');
});

// AJAX ROUTES
Route::group(['prefix' => 'products/ajax', 'middleware' => []], function () {
    
});
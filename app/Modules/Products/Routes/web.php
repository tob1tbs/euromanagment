<?php

// GENERAL ROUTES
Route::group(['prefix' => 'products', 'middleware' => []], function () {
    Route::get('/', 'ProductsController@actionProductsIndex')->name('actionProductsIndex');
    Route::get('/add', 'ProductsController@actionProductsAdd')->name('actionProductsAdd');
    Route::get('/edit/{id}', 'ProductsController@actionProductsEdit')->name('actionProductsEdit');
    Route::get('/categories', 'ProductsController@actionProductsCategory')->name('actionProductsCategory');
    Route::get('/vendors', 'ProductsController@actionProductsVendor')->name('actionProductsVendor');
    Route::get('/brands', 'ProductsController@actionUsersBrands')->name('actionUsersBrands');
    Route::get('/balance/history', 'ProductsController@actionProductsBalanceHistory')->name('actionProductsBalanceHistory');
    Route::get('/balance/history/{id}', 'ProductsController@actionProductsBalanceHistoryList')->name('actionProductsBalanceHistoryList');
});

// AJAX ROUTES
Route::group(['prefix' => 'products/ajax', 'middleware' => []], function () {
    Route::post('/categories/submit', 'ProductsAjaxController@ajaxProductCategoriesSubmit')->name('ajaxProductCategoriesSubmit');
    Route::post('/categories/active', 'ProductsAjaxController@ajaxProductCategoriesActive')->name('ajaxProductCategoriesActive');
    Route::post('/categories/delete', 'ProductsAjaxController@ajaxProductCategoriesDelete')->name('ajaxProductCategoriesDelete');
    Route::get('/categories/get', 'ProductsAjaxController@ajaxProductCategoriesGet')->name('ajaxProductCategoriesGet');
    //
    Route::post('/vendors/submit', 'ProductsAjaxController@ajaxProductVendorSubmit')->name('ajaxProductVendorSubmit');
    Route::post('/vendors/active', 'ProductsAjaxController@ajaxProductVendorActive')->name('ajaxProductVendorActive');
    Route::post('/vendors/delete', 'ProductsAjaxController@ajaxProductVendorDelete')->name('ajaxProductVendorDelete');
    Route::get('/vendors/get', 'ProductsAjaxController@ajaxProductVendorGet')->name('ajaxProductVendorGet');
    //
    Route::post('/brands/submit', 'ProductsAjaxController@ajaxProductBrandSubmit')->name('ajaxProductBrandSubmit');
    Route::post('/brands/active', 'ProductsAjaxController@ajaxProductBrandActive')->name('ajaxProductBrandActive');
    Route::post('/brands/delete', 'ProductsAjaxController@ajaxProductBrandDelete')->name('ajaxProductBrandDelete');
    Route::get('/brands/get', 'ProductsAjaxController@ajaxProductBrandGet')->name('ajaxProductBrandGet');
    //
    Route::get('/warehouse/get', 'ProductsAjaxController@ajaxProductWarehouseGet')->name('ajaxProductWarehouseGet');
    //
    Route::get('/count/', 'ProductsAjaxController@ajaxProductCountGet')->name('ajaxProductCountGet');
    Route::post('/count/submit', 'ProductsAjaxController@ajaxProductSubmitGet')->name('ajaxProductSubmitGet');
    //
    Route::get('/price/history', 'ProductsAjaxController@ajaxProductPriceHistory')->name('ajaxProductPriceHistory');
    Route::post('/price/update', 'ProductsAjaxController@ajaxProductPriceUpdate')->name('ajaxProductPriceUpdate');
    Route::post('/price/delete', 'ProductsAjaxController@ajaxProductPriceDelete')->name('ajaxProductPriceDelete');
    //
    Route::post('/submit', 'ProductsAjaxController@ajaxProductSubmit')->name('ajaxProductSubmit');
});
<?php

// GENERAL ROUTES
Route::group(['prefix' => 'dashboards', 'middleware' => []], function () {
    Route::get('/', 'DashboardController@actionDashboardIndex')->name('actionDashboardIndex');
    Route::get('/orders', 'DashboardController@actionDashboardOrders')->name('actionDashboardOrders');
    Route::get('/reports', 'DashboardController@actionDashboardReports')->name('actionDashboardReports');
});

// AJAX ROUTES
Route::group(['prefix' => 'dashboards/ajax', 'middleware' => []], function () {
    Route::get('/get/products', 'DashboardAjaxController@ajaxGetProductsList')->name('ajaxGetProductsList');
    Route::get('/get/product/data', 'DashboardAjaxController@ajaxGetProductData')->name('ajaxGetProductData');
    // CART
    Route::post('/cart/add', 'DashboardAjaxController@ajaxAddToCart')->name('ajaxAddToCart');
});
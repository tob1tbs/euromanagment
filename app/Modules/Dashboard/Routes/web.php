<?php

// GENERAL ROUTES
Route::group(['prefix' => 'dashboards', 'middleware' => []], function () {
    Route::get('/', 'DashboardController@actionDashboardIndex')->name('actionDashboardIndex');
    Route::get('/orders', 'DashboardController@actionDashboardOrders')->name('actionDashboardOrders');
    Route::get('/reports', 'DashboardController@actionDashboardReports')->name('actionDashboardReports');
});

// AJAX ROUTES
Route::group(['prefix' => 'dashboards/ajax', 'middleware' => []], function () {
    Route::get('/get/fields', 'DashboardAjaxController@ajaxGetCustomerFields')->name('ajaxGetCustomerFields');
});
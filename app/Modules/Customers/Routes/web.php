<?php

// GENERAL ROUTES
Route::group(['prefix' => 'customers', 'middleware' => []], function () {
    Route::get('/', 'CustomersController@actionCustomersIndex')->name('actionCustomersIndex');
    Route::get('/add', 'CustomersController@actionCustomersAdd')->name('actionCustomersAdd');
    Route::get('/view/{customer_id}', 'CustomersController@actionCustomerView')->name('actionCustomerView');
    Route::get('/loality', 'CustomersController@actionCustomersLoality')->name('actionCustomersLoality');
    Route::get('/loality/view/{referal_id}', 'CustomersController@actionCustomersLoalityView')->name('actionCustomersLoalityView');
});

// AJAX ROUTES
Route::group(['prefix' => 'customers/ajax', 'middleware' => []], function () {
    Route::get('/get/fields', 'CustomersAjaxController@ajaxGetFields')->name('ajaxGetFields');
    Route::get('/get/fields/legal', 'CustomersAjaxController@ajaxGetFieldsLegal')->name('ajaxGetFieldsLegal');
    Route::post('/submit', 'CustomersAjaxController@ajaxSubmit')->name('ajaxSubmit');
    Route::post('/referal/pay', 'CustomersAjaxController@ajaxReferalPay')->name('ajaxReferalPay');
    Route::post('/referal/pay/delete', 'CustomersAjaxController@ajaxReferalPayDelete')->name('ajaxReferalPayDelete');
});
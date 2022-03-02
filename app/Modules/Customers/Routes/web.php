<?php

// GENERAL ROUTES
Route::group(['prefix' => 'customers', 'middleware' => []], function () {
    Route::get('/', 'CustomersController@actionCustomersIndex')->name('actionCustomersIndex');
    Route::get('/add', 'CustomersController@actionCustomersAdd')->name('actionCustomersAdd');
});

// AJAX ROUTES
Route::group(['prefix' => 'customers/ajax', 'middleware' => []], function () {
    Route::post('/submit', 'CustomersAjaxController@ajaxCustomersSubmit')->name('ajaxCustomersSubmit');
    Route::post('/active', 'CustomersAjaxController@ajaxCustomersActiveChange')->name('ajaxCustomersActiveChange');
    Route::post('/company/active', 'CustomersAjaxController@ajaxCompanyActiveChange')->name('ajaxCompanyActiveChange');
    
});
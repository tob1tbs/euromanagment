<?php

// GENERAL ROUTES
Route::group(['prefix' => 'orders', 'middleware' => []], function () {
    Route::get('/', 'OrdersController@actionOrdersIndex')->name('actionOrdersIndex');
    Route::get('/add', 'OrdersController@actionOrdersAdd')->name('actionOrdersAdd');
    Route::get('/edit/{order_id}', 'OrdersController@actionOrdersEdit')->name('actionOrdersEdit');
    Route::get('/view/{ordeR_id}', 'OrdersController@actionOrdersView')->name('actionOrdersView');
});

// AJAX ROUTES
Route::group(['prefix' => 'orders/ajax', 'middleware' => []], function () {
    Route::post('/action/submit', 'OrdersAjaxController@ajaxActionSubmit')->name('ajaxActionSubmit');
});
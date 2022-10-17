<?php

// GENERAL ROUTES
Route::group(['prefix' => 'dashboards', 'middleware' => []], function () {
    Route::get('/', 'DashboardController@actionDashboardIndex')->name('actionDashboardIndex');
    Route::get('/orders', 'DashboardController@actionDashboardOrders')->name('actionDashboardOrders');
    Route::get('/orders/view/{order_id}', 'DashboardController@actionDashboardOrdersView')->name('actionDashboardOrdersView');
    Route::get('/orders/edit/{order_id}', 'DashboardController@actionDashboardOrdersEdit')->name('actionDashboardOrdersEdit');
    Route::get('/orders/print/{order_id}', 'DashboardController@actionDashboardOrdersPrint')->name('actionDashboardOrdersPrint');
    Route::get('/orders/print/invoice/{order_id}', 'DashboardController@actionDashboardOrdersInvoicePrint')->name('actionDashboardOrdersInvoicePrint');
    Route::get('/reports', 'DashboardController@actionDashboardReports')->name('actionDashboardReports');
});

// AJAX ROUTES
Route::group(['prefix' => 'dashboards/ajax', 'middleware' => []], function () {
    Route::get('/get/products', 'DashboardAjaxController@ajaxGetProductsList')->name('ajaxGetProductsList');
    Route::get('/get/product/data', 'DashboardAjaxController@ajaxGetProductData')->name('ajaxGetProductData');
    // CUSTOMERS
    Route::get('/get/customers', 'DashboardAjaxController@ajaxGetCustomerData')->name('ajaxGetCustomerData');
    // CART
    Route::post('/cart/add', 'DashboardAjaxController@ajaxAddToCart')->name('ajaxAddToCart');
    Route::post('/cart/clear', 'DashboardAjaxController@ajaxCartClear')->name('ajaxCartClear');
    Route::post('/cart/remove', 'DashboardAjaxController@ajaxCartRemove')->name('ajaxCartRemove');
    Route::post('/cart/quantity', 'DashboardAjaxController@ajaxCartUpdateQuantity')->name('ajaxCartUpdateQuantity');
    Route::post('/cart/submit', 'DashboardAjaxController@ajaxDashboardSubmit')->name('ajaxDashboardSubmit');
    // ORDER
    Route::post('/order/reject', 'DashboardAjaxController@ajaxOrderReject')->name('ajaxOrderReject');
    Route::get('/order/get', 'DashboardAjaxController@ajaxOrderGet')->name('ajaxOrderGet');
    Route::post('/order/close', 'DashboardAjaxController@ajaxOrderClose')->name('ajaxOrderClose');
    Route::post('/order/overhead/send', 'DashboardAjaxController@ajaxOrderOveheadSend')->name('ajaxOrderOveheadSend');
    Route::post('/order/overhead/cancel', 'DashboardAjaxController@ajaxOrderOveheadCancel')->name('ajaxOrderOveheadCancel');
    Route::get('/order/overhead/get', 'DashboardAjaxController@ajaxViewSendOverhead')->name('ajaxViewSendOverhead');
});
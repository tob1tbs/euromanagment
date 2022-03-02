<?php

// GENERAL ROUTES
Route::group(['prefix' => 'parameters', 'middleware' => []], function () {
    Route::get('/basic', 'ParametersController@actionParametersIndex')->name('actionParametersIndex');
    Route::get('/payments', 'ParametersController@actionParametersPayments')->name('actionParametersPayments');
    Route::get('/translate', 'ParametersController@actionParametersTranslate')->name('actionParametersTranslate');
});

// AJAX ROUTES
Route::group(['prefix' => 'parameters/ajax', 'middleware' => []], function () {
    // PAYMENTS
    Route::get('/payments/options', 'ParametersAjaxController@ajaxParameterPaymentOptions')->name('ajaxParameterPaymentOptions');
    Route::post('/payments/active', 'ParametersAjaxController@ajaxParameterPaymentActive')->name('ajaxParameterPaymentActive');
    Route::post('/payments/submit', 'ParametersAjaxController@ajaxParameterPaymentSubmit')->name('ajaxParameterPaymentSubmit');

    // TRANSLATE
    Route::post('/translate/update', 'ParametersAjaxController@ajaxParameterTranslateUpdate')->name('ajaxParameterTranslateUpdate');
    Route::post('/translate/add', 'ParametersAjaxController@ajaxParameterTranslateAdd')->name('ajaxParameterTranslateAdd');
});
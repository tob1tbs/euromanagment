<?php

// GENERAL ROUTES
Route::group(['prefix' => 'reports', 'middleware' => []], function () {
    Route::get('/', 'ReportsController@actionReportsIndex')->name('actionReportsIndex');
});

// AJAX ROUTES
Route::group(['prefix' => 'reports/ajax', 'middleware' => []], function () {
    
});
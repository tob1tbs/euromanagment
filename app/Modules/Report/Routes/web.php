<?php

// GENERAL ROUTES
Route::group(['prefix' => 'reports', 'middleware' => []], function () {
    Route::get('/', 'actionReportController@ReportIndex')->name('actionReportIndex');
});

// AJAX ROUTES
Route::group(['prefix' => 'reports/ajax', 'middleware' => []], function () {
    
});
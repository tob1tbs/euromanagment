<?php

// GENERAL ROUTES
Route::group(['prefix' => 'dashboards', 'middleware' => []], function () {
    Route::get('/', 'DashboardController@actionDashboardIndex')->name('actionDashboardIndex');
});

// AJAX ROUTES
Route::group(['prefix' => 'dashboards/ajax', 'middleware' => []], function () {
    
});
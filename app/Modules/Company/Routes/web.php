<?php

// GENERAL ROUTES
Route::group(['prefix' => 'company', 'middleware' => []], function () {
    Route::get('/branch', 'CompanyController@actionCompanyBranch')->name('actionCompanyBranch');
});

// AJAX ROUTES
Route::group(['prefix' => 'company/ajax', 'middleware' => []], function () {
    
});
<?php

// GENERAL ROUTES
Route::group(['prefix' => 'company', 'middleware' => ['login']], function () {
    Route::get('/branch', 'CompanyController@actionCompanyBranch')->name('actionCompanyBranch');
});

// AJAX ROUTES
Route::group(['prefix' => 'company/ajax', 'middleware' => ['login']], function () {
    Route::post('/branch/submit', 'CompanyAjaxController@ajaxCompanyBranchSubmit')->name('ajaxCompanyBranchSubmit');
});
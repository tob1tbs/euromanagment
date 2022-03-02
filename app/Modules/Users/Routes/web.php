<?php

// GENERAL ROUTES
Route::group(['prefix' => 'users', 'middleware' => []], function () {
    Route::get('/', 'UsersController@actionUsersIndex')->name('actionUsersIndex');
    Route::get('/add', 'UsersController@actionUsersAdd')->name('actionUsersAdd');
    Route::get('/edit/{user_id}', 'UsersController@actionUsersEdit')->name('actionUsersEdit');

    Route::get('/role', 'UsersController@actionUsersRole')->name('actionUsersRole');
});

// AJAX ROUTES
Route::group(['prefix' => 'users/ajax', 'middleware' => []], function () {
    // USERS ROLE
    Route::post('/role/submit', 'UsersAjaxController@ajaxUserRoleSubmit')->name('ajaxUserRoleSubmit');
    Route::post('/role/active', 'UsersAjaxController@ajaxUserRoleActiveChange')->name('ajaxUserRoleActiveChange');
    Route::post('/role/delete', 'UsersAjaxController@ajaxUserRoleDelete')->name('ajaxUserRoleDelete');
    Route::get('/role/edit', 'UsersAjaxController@ajaxUserRoleEdit')->name('ajaxUserRoleEdit');
    Route::get('/role/permission', 'UsersAjaxController@ajaxUserRolePermissions')->name('ajaxUserRolePermissions');
    Route::post('/role/permission/submit', 'UsersAjaxController@ajaxUserRolePermissionsSubmit')->name('ajaxUserRolePermissionsSubmit');
    Route::post('/role/permission/sync', 'UsersAjaxController@ajaxUserRolePermissionsSync')->name('ajaxUserRolePermissionsSync');
    Route::post('/role/permission/delete', 'UsersAjaxController@ajaxUserRolePermissionsDelete')->name('ajaxUserRolePermissionsDelete');
});
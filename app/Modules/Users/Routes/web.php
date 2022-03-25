<?php

// GENERAL ROUTES
Route::get('/login', 'UsersController@actionUsersLogin')->name('actionUsersLogin');
Route::post('/users/ajax/login/submit', 'UsersAjaxController@ajaxUserLogin')->name('ajaxUserLogin');

Route::group(['prefix' => 'users', 'middleware' => ['login']], function () {
    Route::get('/', 'UsersController@actionUsersIndex')->name('actionUsersIndex');
    Route::get('/add', 'UsersController@actionUsersAdd')->name('actionUsersAdd');
    Route::get('/edit/{user_id}', 'UsersController@actionUsersEdit')->name('actionUsersEdit');
    Route::get('/view/{user_id}', 'UsersController@actionUsersView')->name('actionUsersView');
    Route::get('/role', 'UsersController@actionUsersRole')->name('actionUsersRole');
    Route::get('/positions', 'UsersController@actionUsersPositions')->name('actionUsersPositions');
    Route::get('/calendar', 'UsersController@actionUsersCalendar')->name('actionUsersCalendar');
    Route::get('/salary', 'UsersController@actionUsersSalary')->name('actionUsersSalary');
    Route::get('/logout', 'UsersController@actionUsersLogout')->name('actionUsersLogout');
});

// AJAX ROUTES
Route::group(['prefix' => 'users/ajax', 'middleware' => ['login']], function () {
    // USER
    Route::post('/submit', 'UsersAjaxController@ajaxUserSubmit')->name('ajaxUserSubmit');
    Route::get('/get/departament', 'UsersAjaxController@ajaxGetDepartamentList')->name('ajaxGetDepartamentList');
    Route::get('/role/get', 'UsersAjaxController@ajaxUserRoleGet')->name('ajaxUserRoleGet');
    Route::post('/role/update', 'UsersAjaxController@ajaxUserRoleUpdate')->name('ajaxUserRoleUpdate');
    // USER WORK
    Route::post('/work/add', 'UsersAjaxController@ajaxUserWorkAdd')->name('ajaxUserWorkAdd');
    Route::get('/work/get', 'UsersAjaxController@ajaxUserWorkGet')->name('ajaxUserWorkGet');
    Route::get('/work/get/user/{user_id}', 'UsersAjaxController@ajaxUserWorkGetUser')->name('ajaxUserWorkGetUser');
    Route::get('/work/event', 'UsersAjaxController@ajaxUserWorkEvent')->name('ajaxUserWorkEvent');
    Route::post('/work/delete', 'UsersAjaxController@ajaxUserWorkDelete')->name('ajaxUserWorkDelete');
    // USER SALARY
    Route::post('/salary/submit', 'UsersAjaxController@ajaxUserSalarySubmit')->name('ajaxUserSalarySubmit');
    Route::get('/salary/view', 'UsersAjaxController@ajaxUserSalaryView')->name('ajaxUserSalaryView');
    Route::post('/salary/delete', 'UsersAjaxController@ajaxUserSalaryDelete')->name('ajaxUserSalaryDelete');
    Route::get('/salary/detail', 'UsersAjaxController@ajaxUserSalaryDetail')->name('ajaxUserSalaryDetail');
    // USER VACATION
    Route::post('/vacation/validate', 'UsersAjaxController@ajaxUserVacationValidate')->name('ajaxUserVacationValidate');
    Route::post('/vacation/submit', 'UsersAjaxController@ajaxUserVacationSubmit')->name('ajaxUserVacationSubmit');
    // USERS ROLE
    Route::post('/role/submit', 'UsersAjaxController@ajaxUserRoleSubmit')->name('ajaxUserRoleSubmit');
    Route::post('/role/active', 'UsersAjaxController@ajaxUserRoleActiveChange')->name('ajaxUserRoleActiveChange');
    Route::post('/role/delete', 'UsersAjaxController@ajaxUserRoleDelete')->name('ajaxUserRoleDelete');
    Route::get('/role/edit', 'UsersAjaxController@ajaxUserRoleEdit')->name('ajaxUserRoleEdit');
    Route::get('/role/permission', 'UsersAjaxController@ajaxUserRolePermissions')->name('ajaxUserRolePermissions');
    Route::post('/role/permission/submit', 'UsersAjaxController@ajaxUserRolePermissionsSubmit')->name('ajaxUserRolePermissionsSubmit');
    Route::post('/role/permission/sync', 'UsersAjaxController@ajaxUserRolePermissionsSync')->name('ajaxUserRolePermissionsSync');
    Route::post('/role/permission/delete', 'UsersAjaxController@ajaxUserRolePermissionsDelete')->name('ajaxUserRolePermissionsDelete');
    // USERS POSITION
    Route::post('/position/submit', 'UsersAjaxController@ajaxUserPositionSubmit')->name('ajaxUserPositionSubmit');
    Route::get('/position/edit', 'UsersAjaxController@ajaxUserPositionEdit')->name('ajaxUserPositionEdit');
    Route::post('/position/active', 'UsersAjaxController@ajaxUserPositionActive')->name('ajaxUserPositionActive');
    Route::post('/position/delete', 'UsersAjaxController@ajaxUserPositionDelete')->name('ajaxUserPositionDelete');
});
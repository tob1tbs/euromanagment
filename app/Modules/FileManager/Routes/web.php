<?php

// GENERAL ROUTES
Route::group(['prefix' => 'filemanager', 'middleware' => []], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
 });
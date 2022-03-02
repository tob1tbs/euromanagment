<?php

// GENERAL ROUTES
Route::group(['prefix' => 'products', 'middleware' => []], function () {
    Route::get('/', 'ProductsController@actionProductsIndex')->name('actionProductsIndex');
    Route::get('/add', 'ProductsController@actionProductsAdd')->name('actionProductsAdd');
    Route::get('/edit/{product_id}', 'ProductsController@actionProductsEdit')->name('actionProductsEdit');
    Route::get('/categories', 'ProductsController@actionProductsCategories')->name('actionProductsCategories');
    Route::get('/brands', 'ProductsController@actionProductsBrands')->name('actionProductsBrands');
    Route::get('/options', 'ProductsController@actionProductsOptions')->name('actionProductsOptions');
    Route::get('/vendor', 'ProductsController@actionProductsVendors')->name('actionProductsVendors');
    Route::get('/facebook', 'ProductsController@actionProductsFacebook')->name('actionProductsFacebook');
    Route::get('/balance/history', 'ProductsController@actionProductsBalanceHistory')->name('actionProductsBalanceHistory');
    Route::get('/balance/history/{id}', 'ProductsController@actionProductsBalanceHistoryList')->name('actionProductsBalanceHistoryList');
});

// AJAX ROUTES
Route::group(['prefix' => 'products/ajax', 'middleware' => []], function () {
    // PRODUCTS
    Route::post('/submit', 'ProductsAjaxController@ajaxProductSubmit')->name('ajaxProductSubmit');
    Route::get('/parent', 'ProductsAjaxController@ajaxProductParentImport')->name('ajaxProductParentImport');


    Route::get('/balance/export', 'ProductsAjaxController@ajaxProductBalanceExport')->name('ajaxProductBalanceExport');
    Route::post('/balance/update', 'ProductsAjaxController@ajaxProductBalanceUpdate')->name('ajaxProductBalanceUpdate');
    // CATEGORIES
    Route::post('/categories/submit', 'ProductsAjaxController@ajaxCategoriesAdd')->name('ajaxCategoriesAdd');
    Route::post('/categories/sortable', 'ProductsAjaxController@ajaxCategoriesSortable')->name('ajaxCategoriesSortable');
    Route::post('/categories/active', 'ProductsAjaxController@ajaxCategoriesActive')->name('ajaxCategoriesActive');
    Route::post('/categories/delete', 'ProductsAjaxController@ajaxCategoriesDelete')->name('ajaxCategoriesDelete');
    Route::get('/categories/edit', 'ProductsAjaxController@ajaxCategoriesEdit')->name('ajaxCategoriesEdit');
    Route::get('/categories/child', 'ProductsAjaxController@ajaxCategoriesChild')->name('ajaxCategoriesChild');
    Route::post('/categories/child/submit', 'ProductsAjaxController@ajaxCategoriesChildAdd')->name('ajaxCategoriesChildAdd');
    Route::post('/categories/child/delete', 'ProductsAjaxController@ajaxCategoriesChildDelete')->name('ajaxCategoriesChilddelete');
    Route::post('/categories/child/sortable', 'ProductsAjaxController@ajaxCategoriesChildSortable')->name('ajaxCategoriesChildSortable');
    Route::get('/get/subcategories', 'ProductsAjaxController@ajaxGetSubCategoryList')->name('ajaxGetSubCategoryList');
    Route::get('/get/subcategoriesbrands', 'ProductsAjaxController@ajaxGetSubCategoryAndBrandList')->name('ajaxGetSubCategoryAndBrandList');
    Route::get('/get/brandsbysubcategory', 'ProductsAjaxController@ajaxGetBrandByChildCategory')->name('ajaxGetBrandByChildCategory');
    // BRANDS
    Route::post('/brands/submit', 'ProductsAjaxController@ajaxBrandFormSubmit')->name('ajaxBrandFormSubmit');
    Route::post('/brands/active', 'ProductsAjaxController@ajaxBrandActiveChange')->name('ajaxBrandActiveChange');
    Route::post('/brands/delete', 'ProductsAjaxController@ajaxBrandDelete')->name('ajaxBrandDelete');
    Route::post('/brands/sortable', 'ProductsAjaxController@ajaxBrandSort')->name('ajaxBrandSort');
    Route::get('/brands/edit', 'ProductsAjaxController@ajaxBrandEdit')->name('ajaxBrandEdit');
    //OPTIONS
    Route::post('/options/submit', 'ProductsAjaxController@ajaxOptionSubmit')->name('ajaxOptionSubmit');
    Route::post('/options/active', 'ProductsAjaxController@ajaxOptionActive')->name('ajaxOptionActive');
    Route::get('/options/edit', 'ProductsAjaxController@ajaxOptionOptions')->name('ajaxOptionOptions');
    Route::post('/options/delete', 'ProductsAjaxController@ajaxOptionDelete')->name('ajaxOptionDelete');
    Route::post('/options/sortable', 'ProductsAjaxController@ajaxOptionSortable')->name('ajaxOptionSortable');
    Route::get('/options/value', 'ProductsAjaxController@ajaxOptionValue')->name('ajaxOptionValue');
    Route::post('/options/value/submit', 'ProductsAjaxController@ajaxOptionValueSubmit')->name('ajaxOptionValueSubmit');
    Route::post('/options/value/active', 'ProductsAjaxController@ajaxOptionValueActive')->name('ajaxOptionValueActive');
    Route::post('/options/value/delete', 'ProductsAjaxController@ajaxOptionValueDelete')->name('ajaxOptionValueDelete');
    Route::post('/options/value/sortable', 'ProductsAjaxController@ajaxOptionValueSortable')->name('ajaxOptionValueSortable');
    Route::get('/options/value/edit', 'ProductsAjaxController@ajaxOptionValueEdit')->name('ajaxOptionValueEdit');
    Route::post('/options/value/update', 'ProductsAjaxController@ajaxOptionValueUpdate')->name('ajaxOptionValueUpdate');
    //VENDORS
    Route::post('/vendors/submit', 'ProductsAjaxController@ajaxVendorsSubmit')->name('ajaxVendorsSubmit');
    Route::get('/vendors/edit', 'ProductsAjaxController@ajaxVendorsEdit')->name('ajaxVendorsEdit');
    Route::post('/vendors/active', 'ProductsAjaxController@ajaxVendorsActive')->name('ajaxVendorsActive');
    Route::post('/vendors/delete', 'ProductsAjaxController@ajaxVendorsDelete')->name('ajaxVendorsDelete');
});
<?php

use Illuminate\Support\Facades\Route;

Route::post('/customer', 'Sale\CustomerController@index');
Route::post('/customer/customer_account_list/{id}', 'Sale\CustomerController@show');
Route::post('/store_customer', 'Sale\CustomerController@store');

// ----------
Route::post('/get_customer_account_setting', 'Sale\CustomerController@get_customer_account_setting');
Route::post('/store_customer_account_setting', 'Sale\CustomerController@store_customer_account_setting');

Route::post('/CustomerExport', 'Sale\CustomerController@Export');
Route::post('/CustomerImport', 'Sale\CustomerController@Import');
// ---------------------------------customerGroup------------------
Route::post('/customer_groups', 'Sale\CustomerGroupController@index');
Route::post('/store_customer_group', 'Sale\CustomerGroupController@store');

Route::post('/group_mark_customer', 'GroupController@get_group_mark_customer');

Route::post('/mark_customer', 'Sale\CustomerGroupController@get_mark_customer');
Route::post('/store_account_setting/customer', 'Sale\CustomerController@store_account_setting');

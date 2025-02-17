<?php

use Illuminate\Support\Facades\Route;
Route::post('/mark_bank', 'Account\BankController@get_mark_bank');
Route::post('/store_account_setting/bank', 'Account\BankController@store_account_setting');

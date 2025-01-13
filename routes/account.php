<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Account\AccountController;





Route::post('/tree_account', 'Account\AccountController@tree_account');
Route::post('/tree_account/221', 'Account\AccountController@get_part_tree_account');

Route::post('/account/{id}', 'Account\AccountController@edit');
Route::post('/delete_account/{id}', 'Account\AccountController@destroy');
Route::post('/store_account', 'Account\AccountController@store');
Route::post('/account_list', 'Account\DailyController@index');
Route::post('/account_report/{id}', 'Account\DailyController@account_report');
Route::post('/balance_report', 'Account\AccountController@balance_report');

// Route::post('/account_list/{id}', 'Account\AccountController@AccountStatement');
Route::post('/account_details_node/{id}', 'Account\AccountController@account_details_node');
Route::post('/account_update_node/{id}', 'Account\AccountController@account_update_node');
Route::post('/account_edit_node/{id}', 'Account\AccountController@account_edit_node');
// ------------------------------------------
Route::post('/account_store_first_level', 'Account\AccountController@account_store_first_level');


Route::post('/account_rename_node/{id}', 'Account\AccountController@account_rename_node');
Route::post('/daily', 'Account\DailyController@index');
Route::post('/daily/{id}', 'Account\DailyController@show');
Route::post('/store_daily', 'Account\DailyController@store');
Route::post('/daily_close', 'Account\DailyController@daily_close');
Route::post('/store_daily_openning_balance', 'Account\DailyController@store_daily_openning_balance');
// ---------------------------------------------
Route::post('/get_account_main/{id}', 'Account\AccountController@get_account_main');
Route::post('/get_account_name/{id}', 'Account\AccountController@get_account_name');
Route::post('/get_account_store/{id}', 'Account\AccountController@get_account');
Route::post('/auditBalance', 'Account\AccountController@auditBalance');

// --------------------------------banks------------------------------------------
Route::post('/banks', 'Account\BankController@show');
Route::post('/store_currency', 'Account\CurrencyController@store');
Route::post('/store_bank', 'Account\BankController@store');
Route::post('/get_treasury_accounts', 'Account\AccountController@get_treasury_accounts');
Route::post('/get_bank_accounts', 'Account\AccountController@get_bank_accounts');
Route::post('/groups', 'GroupController@get_groups');
Route::post('/group_marks', 'GroupController@get_group_mark');
Route::post('/group_mark_treasury', 'GroupController@get_group_mark_treasury');
Route::post('/group_mark_bank', 'GroupController@get_group_mark_bank');
Route::post('/get_group/{id}', 'GroupController@get_group');
Route::post('/store_group', 'GroupController@store_group');
Route::post('/store_group_type', 'GroupController@store_group_type');
Route::post('/get_group_accounts_details_details/{id}', 'Account\AccountController@get_group_accounts_details_details');


Route::post('/group_types', 'GroupController@get_group_types');
// --------------------------------Currencies------------------------------------------
Route::post('/currencies', 'Account\CurrencyController@show');
// --------------------------------treasuries------------------------------------------
Route::post('/treasuries', 'Account\TreasuryController@show');
Route::post('/store_treasury', 'Account\TreasuryController@store');
// --------------------------------type_expence------------------------------------------
Route::post('/type_expence', 'Account\TypeExpenceController@show');
// --------------------------------type_income------------------------------------------
Route::post('/type_income', 'Account\TypeIncomeController@show');
// --------------------------------expence_type------------------------------------------
Route::post('/expence_type', 'Account\ExpenceTypeController@show');
Route::post('/expence/newexpence', 'Account\ExpenceController@index');

Route::post('/expence/delete', 'Account\ExpenceController@destroy');

Route::post('/store_expence', 'Account\ExpenceController@store');
Route::post('/store_income', 'Account\ExpenceController@store');


Route::post('/payexpence', 'Account\ExpenceController@payment');

Route::post('/expences', 'Account\ExpenceController@show');

Route::post('/expence/newexpencesearch', 'Account\ExpenceController@search_new');

Route::post('/listexpence', 'Account\ExpenceController@show');

Route::post('/listexpencesearch', 'Account\ExpenceController@search');

Route::post('/expence_details/{id}', 'Account\ExpenceController@details_supply');
Route::post('/invoice_expence/{id}', 'Account\ExpenceController@invoice_supply');
Route::post('/recive_expence/{id}', 'Account\ExpenceController@recive_supply');



Route::post('import_account', [AccountController::class, 'import']);
Route::post('export_account', [AccountController::class, 'export']);

Route::post('/store_account_period', 'Account\PeriodController@store_account_period');
Route::post('/account_year', 'Account\PeriodController@index');

Route::post('/get_account_account_setting', 'Account\AccountController@get_account_account_setting');
// Route::post('/store_account_account_setting', 'Account\AccountController@store_account_account_setting');
Route::post('/store_account_setting', 'GroupController@store_account_setting');








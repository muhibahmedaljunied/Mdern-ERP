<?php

use Illuminate\Support\Facades\Route;

Route::post('/attribute', 'Attribute\AttributeController@index');
Route::post('/attribute_family/get_attributes', 'Attribute\AttributeFamilyController@get_attribute');
Route::post('/product/get_attributes', 'Attribute\AttributeController@get_attribute');
Route::post('/product/get_family_attribute', 'Attribute\AttributeFamilyController@get_family_attribute');
Route::get('/create_attribute', 'Attribute\AttributeController@create');

Route::post('/store_attribute', 'Attribute\AttributeController@store');
Route::post('/update_attribute/{id}', 'Attribute\AttributeController@update');
Route::post('/delete_attribute/{id}', 'Attribute\AttributeController@destroy');

Route::post('/attribute_family_mapping', 'Attribute\AttributeFamilyMappingController@index');
Route::get('/create_attribute_family_mapping', 'Attribute\AttributeFamilyMappingController@create');
Route::post('/edit_attribute_family_mapping/{id}', 'Attribute\AttributeFamilyMappingController@edit');
Route::post('/store_attribute_family_mapping', 'Attribute\AttributeFamilyMappingController@store');
Route::post('/update_attribute_family_mapping/{id}', 'Attribute\AttributeFamilyMappingController@update');

Route::post('/delete_attribute_family_mapping/{id}', 'Attribute\AttributeFamilyMappingController@destroy');

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomepageController@index');

Auth::routes();

Route::get('admin', 'Auth\LoginController@showLoginForm');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {

    Route::resource('page', 'PageController');

    Route::resource('webshop/category', 'WebshopCategoryController');
    Route::get('webshop/category/{category}/destroy', 'WebshopCategoryController@destroy')->name('category.destroy');
    Route::post('webshop/category/sort', 'WebshopCategoryController@sort')->name('category.sort');

    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::post('setting/store', 'SettingController@store')->name('setting.store');

});

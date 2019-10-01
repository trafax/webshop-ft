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

Route::get('webshop', 'WebshopController@index')->name('webshop');
Route::match(['post', 'get'], 'category/{slug}/{any?}', 'CategoryController@index')->name('category')->where('any', '.*');

Auth::routes();

Route::get('admin', 'Auth\LoginController@showLoginForm');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {

    Route::resource('page', 'PageController');

    Route::resource('webshop/category', 'CategoryController');
    Route::get('webshop/category/{category}/destroy', 'CategoryController@destroy')->name('category.destroy');
    Route::post('webshop/category/sort', 'CategoryController@sort')->name('category.sort');

    Route::resource('webshop/product', 'ProductController');
    Route::get('webshop/product/{product}/destroy', 'ProductController@destroy')->name('product.destroy');

    Route::resource('webshop/variation', 'VariationController');
    Route::get('webshop/variation/{variation}/destroy', 'VariationController@destroy')->name('variation.destroy');
    Route::post('webshop/variation/sort', 'VariationController@sort')->name('variation.sort');

    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::post('setting/store', 'SettingController@store')->name('setting.store');

    Route::post('asset/upload', 'AssetController@upload')->name('asset.upload');
    Route::get('asset/delete/{asset}/{hash?}', 'AssetController@delete')->name('asset.delete');
    Route::post('asset/sort', 'AssetController@sort')->name('asset.sort');

});

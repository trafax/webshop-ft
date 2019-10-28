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

Route::localized(function () {
    Route::get('/', 'HomepageController@index')->name('homepage');

    Route::get('language/set/{language}', 'LanguageController@set_language')->name('language.set');

    Route::get('webshop', 'WebshopController@index')->name('webshop');
    Route::get('category/{slug}/{any?}', 'CategoryController@index')->name('category')->where('any', '.*');
    Route::post('category/set_filter/{any?}', 'CategoryController@set_variations_filter')->name('category.set_variation_filter')->where('any', '.*');

    Route::get('product/{slug}', 'ProductController@index')->name('product');

    Route::get('cart', 'CartController@index')->name('cart');
    Route::post('cart/store/{product}', 'CartController@store')->name('cart.store');
    Route::get('cart/delete/{row_id}', 'CartController@delete')->name('cart.delete');

    Route::get('customer', 'CustomerController@index')->name('customer');
    Route::get('customer/logout', 'CustomerController@logout')->name('customer.logout');

    Route::get('customer/edit', 'CustomerController@edit')->name('customer.edit');
    Route::post('customer/update', 'CustomerController@update')->name('customer.update');

    Route::get('checkout', 'CheckoutController@index')->name('checkout');
    Route::post('checkout/place_order', 'CheckoutController@place_order')->name('checkout.place_order');
    Route::post('checkout/webhook', 'CheckoutController@webhook_payment')->name('checkout.webhook_payment');
    Route::get('checkout/return/{order}', 'CheckoutController@return_payment')->name('checkout.return_payment');
});



Auth::routes();

Route::get('admin', 'Auth\LoginController@showLoginForm');
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {

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

    Route::resource('language', 'LanguageController');
    Route::get('language/{language}/destroy', 'LanguageController@destroy')->name('language.destroy');
    Route::post('language/sort', 'LanguageController@sort')->name('language.sort');

    Route::get('translate', 'TranslateController@modal')->name('translate');
    Route::post('translate/store', 'TranslateController@store')->name('translate.store');

    Route::resource('country', 'CountryController');
    Route::get('country/{country}/destroy', 'CountryController@destroy')->name('country.destroy');
});

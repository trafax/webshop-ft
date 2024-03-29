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

use Illuminate\Support\Facades\Lang;

Route::get('admin', 'Auth\LoginController@showLoginForm');
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'auth:admin'], function () {

    Route::get('export', 'ExportController@index');

    Route::get('page/tinymce', 'PageController@tinymce_links');
    Route::resource('page', 'PageController');
    Route::get('page/{page}/destroy', 'PageController@destroy')->name('page.destroy');
    Route::post('page/sort', 'PageController@sort')->name('page.sort');

    Route::resource('webshop/category', 'CategoryController');
    Route::get('webshop/category/{category}/destroy', 'CategoryController@destroy')->name('category.destroy');
    Route::post('webshop/category/sort', 'CategoryController@sort')->name('category.sort');

    Route::match(['get', 'post'], 'webshop/product/search', 'ProductController@search')->name('product.search');
    Route::get('webshop/product/filter', 'ProductController@index');
    Route::resource('webshop/product', 'ProductController');
    Route::get('webshop/product/filter/{any?}', 'ProductController@index')->name('product')->where('any', '.*');
    Route::get('webshop/product/{product}/destroy', 'ProductController@destroy')->name('product.destroy');
    Route::post('webshop/product/setViewMode/{show}', 'ProductController@setViewMode')->name('product.set_view_mode');
    Route::post('webshop/product/deleteSelected', 'ProductController@deleteSelected')->name('product.delete_selected');
    Route::post('webshop/product/setSoldOut/{sold_out}', 'ProductController@setSoldOut')->name('product.set_sold_out');
    Route::post('webshop/set_filter', 'ProductController@set_variations_filter')->name('product.set_variation_filter');
    Route::get('webshop/product/season/{any}/{season}', 'ProductController@index')->name('product.season');

    Route::resource('webshop/variation', 'VariationController');
    Route::get('webshop/variation/{variation}/destroy', 'VariationController@destroy')->name('variation.destroy');
    Route::post('webshop/variation/sort', 'VariationController@sort')->name('variation.sort');

    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::post('setting/store', 'SettingController@store')->name('setting.store');

    Route::post('asset/upload', 'AssetController@upload')->name('asset.upload');
    Route::post('asset/upload_tinymce', 'AssetController@upload_tinymce')->name('asset.upload_tinymce');
    Route::get('asset/delete/{asset}/{hash?}', 'AssetController@delete')->name('asset.delete');
    Route::post('asset/sort', 'AssetController@sort')->name('asset.sort');
    Route::post('asset/update', 'AssetController@update')->name('asset.update');


    Route::resource('language', 'LanguageController');
    Route::get('language/{language}/destroy', 'LanguageController@destroy')->name('language.destroy');
    Route::post('language/sort', 'LanguageController@sort')->name('language.sort');

    Route::get('translate', 'TranslateController@modal')->name('translate');
    Route::post('translate/store', 'TranslateController@store')->name('translate.store');

    Route::resource('country', 'CountryController');
    Route::get('country/{country}/destroy', 'CountryController@destroy')->name('country.destroy');

    Route::resource('shipping', 'ShippingController');
    Route::get('shipping/{shipping}/destroy', 'ShippingController@destroy')->name('shipping.destroy');

    Route::resource('shipping/rule', 'ShippingRuleController');
    Route::get('shipping/rule/{rule}/destroy', 'ShippingRuleController@destroy')->name('rule.destroy');

    Route::resource('emailTemplate', 'EmailTemplateController');

    Route::get('order', 'OrderController@index')->name('order.index');
    // Route::get('order/create', 'OrderController@create')->name('order.create');
    Route::get('order/{order}/show', 'OrderController@show')->name('order.show');
    Route::get('order/{order}/destroy', 'OrderController@destroy')->name('order.destroy');
    Route::get('order/{order}/download_invoice', 'OrderController@download_invoice')->name('order.download_invoice');
    Route::put('order/{order}/update', 'OrderController@update')->name('order.update');
    Route::get('order/create', 'OrderController@create')->name('order.create');
    Route::post('order/store', 'OrderController@store')->name('order.store');
    Route::get('order/add_invoice_rule', 'OrderController@add_invoice_rule')->name('order.add_invoice_rule');
    Route::get('order/{orderRule}/delete_row', 'OrderController@delete_row')->name('order.delete_row');
    Route::post('order/{order}/store_invoice_rule', 'OrderController@store_invoice_rule')->name('order.store_invoice_rule');
    Route::any('order/search', 'OrderController@search')->name('order.search');
    Route::get('order/{status}', 'OrderController@index')->name('order.filter');


    Route::resource('form', 'FormController');
    Route::get('form/{form}/destroy', 'FormController@destroy')->name('form.destroy');
    Route::get('form/{block}/block_edit', 'FormController@block_edit')->name('form.block.edit');
    Route::put('form/{block}/block_update', 'FormController@block_update')->name('form.block.update');

    Route::resource('form_field', 'FormFieldController');
    Route::get('form_field/{form_field}/destroy', 'FormFieldController@destroy')->name('form_field.destroy');
    Route::post('form_field/sort', 'FormFieldController@sort')->name('form_field.sort');

    Route::resource('form_value', 'FormValueController');
    Route::get('form_value/{form_value}/destroy', 'FormValueController@destroy')->name('form_value.destroy');
    Route::post('form_value/sort', 'FormValueController@sort')->name('form_value.sort');

    Route::resource('block', 'BlockController');
    Route::post('block/sort', 'BlockController@sort')->name('block.sort');
    Route::get('block/{block}/destroy', 'BlockController@destroy')->name('block.destroy');

    Route::get('text/{block}/edit', 'TextController@edit')->name('text.edit');
    Route::put('text/{block}/update', 'TextController@update')->name('text.update');
    Route::put('text/{block}/save_text', 'TextController@save_text')->name('text.save_text');

    Route::get('parallax/{block}/edit', 'ParallaxController@edit')->name('parallax.edit');
    Route::put('parallax/{block}/update', 'ParallaxController@update')->name('parallax.update');

    Route::get('advertention/{block}/edit', 'AdvertentionController@edit')->name('advertention.edit');
    Route::put('advertention/{block}/update', 'AdvertentionController@update')->name('advertention.update');

    Route::get('featured_articles/{block}/edit', 'Featured_articlesController@edit')->name('featured.edit');
    Route::put('featured_articles/{block}/update', 'Featured_articlesController@update')->name('featured.update');

    Route::post('related_product/insert', 'Related_productController@insert')->name('related_product.insert');
    Route::get('related_product/delete', 'Related_productController@delete')->name('related_product.delete');

    Route::match(['get', 'post'], 'customer/search_by_product', 'CustomerController@searchByProduct')->name('customer.search_by_product');
    Route::get('customer/export', 'CustomerController@export')->name('customer.export');
    Route::resource('customer', 'CustomerController');
    Route::get('customer/{user_id}/destroy', 'CustomerController@destroy')->name('customer.destroy');

    Route::resource('gallery', 'GalleryController');
    Route::get('gallery/{gallery}/destroy', 'GalleryController@destroy')->name('gallery.destroy');

    Route::get('overview', 'OverviewController@index')->name('overview');

    Route::get('import', 'ImportController@index');
});

Route::localized(function () {

    Auth::routes();

    Route::get('home', 'HomepageController@index');

    Route::get('feed', 'WebshopController@products_feed');

    if (setting('landingpage') ?? 0 == 1) {
        Route::get('/', 'LandingpageController@index');
        Route::get('/home', 'HomepageController@index')->name('homepage');
    } else {
        Route::get('/', 'HomepageController@index')->name('homepage');
    }
    Route::get('landingpage', 'LandingpageController@index');

    Route::get('import', 'ImportController@index');

    Route::get('language/set/{language}', 'LanguageController@set_language')->name('language.set');

    Route::post('form/send/{form}', 'FormController@send')->name('form.send');

    Route::post('mailchimp/subscribe', 'MailchimpController@subscribe')->name('mailchimp.subscribe');

    Route::get('mailchimp/product', 'MailchimpController@product');

    Route::get('webshop', 'WebshopController@index')->name('webshop');
    Route::match(['post', 'get'], 'webshop/search', 'ProductController@search')->name('product.search');
    Route::get('category/all/{any?}', 'CategoryController@all')->name('category.all')->where('any', '.*');
    Route::get('category/{slug}/{any?}', 'CategoryController@index')->name('category')->where('any', '.*');
    Route::get('webshop/category/{slug}/{any?}', 'CategoryController@index')->name('category')->where('any', '.*');
    Route::post('category/set_filter/{any?}', 'CategoryController@set_variations_filter')->name('category.set_variation_filter')->where('any', '.*');

    Route::get('product/{slug}', 'ProductController@index')->name('product');
    Route::get('webshop/product/{slug}', 'ProductController@index')->name('product');

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

    Route::get('order', 'OrderController@index')->name('order.index')->middleware('auth');
    Route::get('order/{id}/show', 'OrderController@show')->name('order.show')->middleware('auth');
    Route::get('order/{id}/download_invoice', 'OrderController@download_invoice')->name('order.download_invoice')->middleware('auth');

    Route::any('{slug?}', 'PageController@index')->name('page')->where('slug', '[a-z-]{3,}');
});

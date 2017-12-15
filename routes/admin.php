<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', [
    'as' => 'backend.dashboard', 
    'uses' => 'BackendController@index'
]);

Route::group(['as' => 'backend.'], function() {
    Auth::routes();
    // Users
    Route::get('users/anydata', ['as' => 'users.data', 'uses' => 'UserController@anyData']);
    Route::resource('users', 'UserController');
    // Product Category
    Route::get('categories/anydata', ['as' => 'categories.data', 'uses' => 'CategoryController@anyData']);
    Route::resource('categories', 'CategoryController');
    // Product
    Route::get('products/anydata', ['as' => 'products.data', 'uses' => 'ProductController@anyData']);
    Route::resource('products', 'ProductController');
    // Order
    Route::get('orders/anydata', ['as' => 'orders.data', 'uses' => 'OrderController@anyData']);
    Route::resource('orders', 'OrderController');
    Route::post('orders/status/update', ['as' => 'orders.status.update', 'uses' => 'OrderController@updateStatus']);
    Route::get('orders/{id}/print-label', 'OrderController@printLabel');
    // FAQ
    Route::get('faqs/anydata', ['as' => 'faqs.data', 'uses' => 'FaqController@anyData']);
    Route::resource('faqs', 'FaqController');
    // Contacts
    Route::get('contacts/anydata', ['as' => 'contacts.data', 'uses' => 'ContactController@anyData']);
    Route::resource('contacts', 'ContactController');
    // Wallet Transaction
    Route::get('wallets/anydata', ['as' => 'wallets.data', 'uses' => 'WalletController@anyData']);
    Route::resource('wallets', 'WalletController');
    // Banks
    Route::get('banks/anydata', ['as' => 'banks.data', 'uses' => 'BankController@anyData']);
    Route::resource('banks', 'BankController');
    // Provinces, Cities, Districts
    Route::get('/locations/sync', ['as' => 'locations.sync', 'uses' => 'ProvinceController@sync']);
    Route::get('provinces/anydata', ['as' => 'provinces.data', 'uses' => 'ProvinceController@anyData']);
    Route::resource('provinces', 'ProvinceController');
    Route::get('cities/anydata', ['as' => 'cities.data', 'uses' => 'CityController@anyData']);
    Route::resource('cities', 'CityController');
    Route::get('districts/anydata', ['as' => 'districts.data', 'uses' => 'DistrictController@anyData']);
    Route::resource('districts', 'DistrictController');
    // Banners
    Route::get('banners/anydata', ['as' => 'banners.data', 'uses' => 'BannerController@anyData']);
    Route::resource('banners', 'BannerController');
    // Pages
    Route::get('pages/anydata', ['as' => 'pages.data', 'uses' => 'PageController@anyData']);
    Route::resource('pages', 'PageController');
    // Social Media
    Route::get('social-media/anydata', ['as' => 'social-media.data', 'uses' => 'SocialMediaController@anyData']);
    Route::resource('social-media', 'SocialMediaController');
     
});
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
// Home
Route::get('/', 'HomeController@index')->name('home');
// Products
Route::get('/products', 'ProductController@index')->name('products');
Route::get('/products/{category}', 'ProductController@indexCategory')->name('products.category');
Route::get('/products/{category}/{product}', 'ProductController@show')->name('products.detail');
//  Profile
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
Route::post('/profile/update', 'ProfileController@update')->name('profile.update');
// Wallet
Route::get('/wallet', 'WalletController@index')->name('wallet');
Route::post('/wallet', 'WalletController@transaction')->name('wallet.transaction');
//  Carts
Route::get('/cart', 'CartController@index')->name('cart');
Route::post('/cart/add', 'CartController@store')->name('cart.store');
Route::post('/cart/remove', 'CartController@remove')->name('cart.remove');
Route::get('/cart/checkout', 'CartController@checkout')->name('checkout');
Route::post('/cart/checkout/order', 'CartController@cartCheckout')->name('checkout.order');
Route::post('/cart/get-city', 'CartController@getCity')->name('cart.getcityprovince');
Route::post('/cart/get-district', 'CartController@getDistrict')->name('cart.getdistrictcity');
Route::post('/cart/get-tariff', 'CartController@getTariff')->name('cart.gettariff');
Route::get('/orders/thank-you/{id}', 'CartController@thanks')->name('orders.thanks');
Route::post('/orders/thank-you', 'CartController@thanksConfirm')->name('orders.thanks.confirm');
// Orders
Route::get('/orders', 'OrderController@index')->name('orders');
Route::get('/orders/{orderid}/detail', 'OrderController@show')->name('orders.detail');
Route::post('/orders/confirmation', 'OrderController@confirm')->name('orders.confirm');
// Wishlist
Route::get('/wishlists', 'WishlistController@index')->name('wishlists');
Route::post('/wishlists/add', 'WishlistController@store')->name('wishlists.store');
Route::post('/wishlists/remove', 'WishlistController@remove')->name('wishlists.remove');
// Contacts
Route::get('/contacts', 'ContactController@index')->name('contacts');
Route::post('/contacts', 'ContactController@store')->name('contacts.store');
// FAQ
Route::get('/faq', 'FAQController@index')->name('faqs');
// About
Route::get('/about', 'StaticController@aboutIndex')->name('about');
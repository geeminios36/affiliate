<?php

/*
|--------------------------------------------------------------------------
| POS Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/pos/products', 'PosController@search')->name('pos.search_product');
Route::get('/variants', 'PosController@getVarinats')->name('variants');
Route::post('/add-to-cart-pos', 'PosController@addToCart')->name('pos.addToCart');
Route::post('/update-quantity-cart-pos', 'PosController@updateQuantity')->name('pos.updateQuantity');
Route::post('/remove-from-cart-pos', 'PosController@removeFromCart')->name('pos.removeFromCart');
Route::post('/get_shipping_address', 'PosController@getShippingAddress')->name('pos.getShippingAddress');
Route::post('/get_shipping_address_seller', 'PosController@getShippingAddressForSeller')->name('pos.getShippingAddressForSeller');
Route::post('/setDiscount', 'PosController@setDiscount')->name('pos.setDiscount');
Route::post('/setShipping', 'PosController@setShipping')->name('pos.setShipping');
Route::post('/pos-order', 'PosController@order_store')->name('pos.order_place');
Route::post('/order-delivery-place', 'PosController@orderDeliveryPlace')->name('pos.order_delivery_place');

//Admin
Route::group(['prefix' =>'admin', 'middleware' => ['auth', 'admin']], function(){
	//pos
	Route::get('/pos', 'PosController@index')->name('poin-of-sales.index');
	Route::get('/pos-activation', 'PosController@pos_activation')->name('poin-of-sales.activation');
});
Route::group(['prefix' =>'seller', 'middleware' => ['seller', 'verified']], function(){
    //pos
	Route::get('/pos', 'PosController@index')->name('poin-of-sales.seller_index');
});

//choice delivery partner
Route::post('/get_form_register_delivery/{delivery_tenancy_id?}', 'PosRegisterDeliveryController@getFormRegisterDelivery')->name('pos.get_form_register_delivery');
Route::post('/get_ward_by_district_id/{district_id?}', 'PosRegisterDeliveryController@getWardByDistrictId')->name('pos.get_ward_by_district_id');
Route::post('/get_shipping_fee/', 'PosRegisterDeliveryController@getShippingFee')->name('pos.get_shipping_fee');
Route::post('/get_locations/', 'PosRegisterDeliveryController@getLocations')->name('pos.get_locations');

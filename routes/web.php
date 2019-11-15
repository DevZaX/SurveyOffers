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

Route::get("/","IndexController@index");

Route::get('offers','OfferController@index');
Route::get('users','UserController@index');

//api

Route::get("api/users","UserController@indexApi");
Route::post("api/users","UserController@storeApi");
Route::put("api/users/{id}","UserController@updateApi");
Route::delete("api/users/{id}","UserController@deleteApi");

Route::get("api/getOffers","OfferController@indexApi");
Route::post("api/storeOffer","OfferController@storeApi");
Route::delete("api/deleteOffer/{id}","OfferController@destroyApi");
Route::put("api/offers/{id}","OfferController@updateApi");

Route::post("api/uploadImage","ImageController@store");
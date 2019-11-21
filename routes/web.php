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

Route::get("users","UserController@index");

Route::get("groups","GroupController@index");

Route::get("auth","AuthController@edit");
Route::get("logout","AuthController@destory");

Route::get("profile","UserController@edit");

//api

Route::get("api/users","UserController@indexApi");
Route::post("api/users","UserController@storeApi");
Route::put("api/users/{id}","UserController@updateApi");
Route::get("api/users/{id}","UserController@editApi");
Route::delete("api/users/{id}","UserController@deleteApi");

Route::get("api/offers/groups","OfferController@groups");
Route::get("api/getOffers","OfferController@indexApi");
Route::post("api/storeOffer","OfferController@storeApi");
Route::delete("api/deleteOffer/{id}","OfferController@destroyApi");
Route::put("api/offers/{id}","OfferController@updateApi");
Route::post("api/action/{action}","OfferController@action");



Route::get("api/getGroups","GroupController@indexApi");
Route::post("api/storeGroup","GroupController@storeApi");
Route::delete("api/deleteGroup/{id}","GroupController@destroyApi");
Route::put("api/groups/{id}","GroupController@updateApi");

Route::post("api/uploadImage","ImageController@store");

Route::post("api/auth","AuthController@create");
Route::get("api/auth","AuthController@show");
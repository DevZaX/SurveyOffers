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

Route::get("categories","CategoryController@index");

Route::get("templates","TemplateController@index");

Route::get("domains","DomainController@index");

Route::get("themes","ThemeController@index");

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
Route::post("api/allOffers","OfferController@all");



Route::get("api/getGroups","GroupController@indexApi");
Route::post("api/storeGroup","GroupController@storeApi");
Route::delete("api/deleteGroup/{id}","GroupController@destroyApi");
Route::put("api/groups/{id}","GroupController@updateApi");
Route::get("api/AllGroups","GroupController@all");


Route::get("api/getTemplates","TemplateController@indexApi");
Route::post("api/storeTemplate","TemplateController@storeApi");
Route::delete("api/deleteTemplate/{id}","TemplateController@destroyApi");
Route::put("api/templates/{id}","TemplateController@updateApi");
Route::post("api/attachOfferToTemplate","TemplateController@attachOfferToTemplate");
Route::post("api/detachOfferFromTemplate","TemplateController@detachOfferFromTemplate");
Route::get("api/templateOffers/{id}","TemplateController@templateOffers");

Route::get("api/getDomains","DomainController@indexApi");
Route::post("api/storeDomain","DomainController@storeApi");
Route::delete("api/deleteDomain/{id}","DomainController@destroyApi");
Route::put("api/domains/{id}","DomainController@updateApi");
Route::get("api/getDomainByGroupId/{id}","DomainController@getDomainByGroupId");

Route::get("api/getThemes","ThemeController@indexApi");
Route::post("api/storeTheme","ThemeController@storeApi");
Route::delete("api/deleteTheme/{id}","ThemeController@destroyApi");
Route::put("api/themes/{id}","ThemeController@updateApi");
Route::get("api/getThemes/{geo}","ThemeController@getThemes");
Route::get("api/getAllTheme","ThemeController@getAllTheme");




Route::get("api/getCategories","CategoryController@indexApi");
Route::post("api/storeCategory","CategoryController@storeApi");
Route::delete("api/deleteCategory/{id}","CategoryController@destroyApi");
Route::put("api/categories/{id}","CategoryController@updateApi");
Route::get("api/AllCategories","CategoryController@all");

Route::post("api/uploadImage","ImageController@store");

Route::post("api/auth","AuthController@create");
Route::get("api/auth","AuthController@show");
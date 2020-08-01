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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test','TestController@index');
Route::get('/user/info','TestController@userInfo');


Route::get('/test/aes','TestController@aesEncrypt');
Route::post('/rsaEncrypt','TestController@rsaEncrypt');
Route::get('/test/sign','TestController@sign');
Route::get('/test/rsaSign','TestController@rsaSign');
Route::get('/test/rsaPostSign','TestController@rsaPostSign');


Route::get('/test/aesSign','TestController@aesSign');
Route::get('/test/header','TestController@header');
Route::get('api','TestController@api');

/**
 * 支付宝自己生成sdk
 */
Route::get('/test/pay','TestController@testPay');
Route::get('pay','TestController@pay');
Route::post('/');


/**
 * 电商项目
 */
Route::any('login','UserController@login');
Route::any('register','UserController@register');
Route::get('center','UserController@center');
Route::get('index','IndexController@index');


Route::get('/oauth/authorize','TestController@testAuthorize');
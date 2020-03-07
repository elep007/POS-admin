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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});



Route::post('/v1/signup', 'ApisInfraController@signup');
Route::post('/v1/signin', 'ApisInfraController@signin');
Route::post('/v1/forgotPassword', 'ApisInfraController@forgotPassword');
Route::post('/v1/emailverify', 'ApisInfraController@emailverify');



Route::post('/v1/getTatbles', 'ApisInfraController@getTatbles');
Route::get('/v1/getTatbles', 'ApisInfraController@getTatbles');

Route::post('/v1/getListTatble', 'ApisInfraController@getListTatble');
Route::get('/v1/getListTatble', 'ApisInfraController@getListTatble');

Route::post('/v1/getProducts', 'ApisInfraController@getProducts');
Route::post('/v1/posttransaction', 'ApisInfraController@posttransaction');


Route::post('/v1/getspecifiedtabletransactions', 'ApisInfraController@getspecifiedtabletransactions');
Route::post('/v1/setStatus', 'ApisInfraController@setStatus');



Route::post('/v1/addOrder', 'ApisInfraController@addOrder');
Route::post('/v1/getOrdersFromTable', 'ApisInfraController@getOrdersFromTable');
Route::post('/v1/deleteOrderItem', 'ApisInfraController@deleteOrderItem');
Route::post('/v1/changeOrderItem', 'ApisInfraController@changeOrderItem');
Route::post('/v1/bill', 'ApisInfraController@bill');
Route::post('/v1/complete', 'ApisInfraController@complete');

Route::post('/v1/getReport1FromTable', 'ApisInfraController@getReport1FromTable');
Route::post('/v1/getReport2FromTable', 'ApisInfraController@getReport2FromTable');


























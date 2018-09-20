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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('client/create', 'ClientController@store')->name('client.create');
Route::get('client/{id}', 'ClientController@view')->name('client.view');
Route::put('client/{id}', 'ClientController@update')->name('client.update');
Route::delete('client/{id}', 'ClientController@destroy')->name('client.delete');

Route::post('account/create', 'AccountController@store')->name('account.create');
Route::get('account/{id}', 'AccountController@view')->name('account.view');
Route::put('account/{id}', 'AccountController@update')->name('account.update');
Route::delete('account/{id}', 'AccountController@destroy')->name('account.delete');
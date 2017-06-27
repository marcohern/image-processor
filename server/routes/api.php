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

Route::resource('images','ImageController');
Route::post('images/upload','ImageController@upload');
Route::post('images/attach','ImageController@attach');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

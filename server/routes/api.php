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

Route::resource('images','ImageProcesor\ImageController');
Route::post('images/upload','ImageProcesor\ImageController@upload');
Route::post('images/attach','ImageProcesor\ImageController@attach');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

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

Route::get('/i/{domain}/{profile}/{density}/{slug}/{index}', 'ImageController@display_all');
Route::get('/i/{domain}/{slug}/{index}'                    , 'ImageController@display_dsi');
Route::get('/i/{slug}/{index}'                             , 'ImageController@display_si');

Route::get('/i/{domain}/{profile}/{density}/{slug}'        , 'ImageController@display_dxs');
Route::get('/i/{domain}/{slug}'                            , 'ImageController@display_ds');
Route::get('/i/{slug}'                                     , 'ImageController@display_s');


Route::get('/', function () {
    return view('welcome');
});
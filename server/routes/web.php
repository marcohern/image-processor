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
Route::pattern('index'  ,'\d+');
Route::pattern('domain' , '[\w_-]+');
Route::pattern('profile', '[\w_-]+');
Route::pattern('density', '[\w_-]+');

Route::get('/i/{domain}/{profile}/{density}/{slug}/{index}', 'ImageProcesor\ImageController@display_all');
Route::get('/i/{domain}/{slug}/{index}'                    , 'ImageProcesor\ImageController@display_dsi');
Route::get('/i/{slug}/{index}'                             , 'ImageProcesor\ImageController@display_si');

Route::get('/i/{domain}/{profile}/{density}/{slug}'        , 'ImageProcesor\ImageController@display_dxs');
Route::get('/i/{domain}/{slug}'                            , 'ImageProcesor\ImageController@display_ds');
Route::get('/i/{slug}'                                     , 'ImageProcesor\ImageController@display_s');


Route::get('/', function () {
    return view('welcome');
});
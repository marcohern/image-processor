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

Route::get('/', function () {
    return view('welcome');
});
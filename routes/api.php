<?php

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

Route::post('/login', 'UserController@login');
Route::resource('admin', 'TruismController')->middleware('auth:api');
Route::get('/truism/{id}', 'TruismController@show');
Route::post('/interact', 'TruismController@interact');
Route::any('/logout', function () {return response()->json(['status' => 'true'], 200);});
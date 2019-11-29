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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/cars', function (Request $request) {
    return 'From the server: details of two cars';
});


// Route::middleware(['auth:api'])->get('/v1/cars', 'Controller_Cars@get');

Route::get('/v1/modules','modulesController@get');

Route::get('/v1/modules/{id}/progress','modulesController@getLagging');
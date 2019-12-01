<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/modules','modulesController@get');

Route::get('/v1/modules/{id}/progress','modulesController@getProgress');

Route::get('/v1/modules/{id}/lagging','modulesController@getLagging');

Route::get('/v1/modules/{id}/contact-lagging','modulesController@contactLagging');

Route::get('/v1/modules/{id}/contact-all-lagging','modulesController@contactAllLagging');

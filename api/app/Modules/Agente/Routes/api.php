<?php

use Illuminate\Http\Request;


Route::get('/agente', function (Request $request) {

    return $request->agente();
});
//
//Route::group([
//    'middleware' => 'api',
//    'prefix' => 'auth'
//
//], function ($router) {
////    Route::post('login', 'AuthController@login');
////    Route::post('logout', 'AuthController@logout');
////    Route::post('refresh', 'AuthController@refresh');
////    Route::get('me', 'AuthController@me');
//});

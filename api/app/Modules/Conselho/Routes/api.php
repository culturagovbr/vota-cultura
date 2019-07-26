<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'conselho'
], function ($router) {
//    Route::get('/', function (Request $request) {
//        return [
//            'rota padrao'
//        ];
//    });
    Route::apiResource('/', 'ConselhoController');
});

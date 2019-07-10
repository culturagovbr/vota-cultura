<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'conta'
], function ($router) {
    Route::get('/', function (Request $request) {
        return [
            'rota padrao'
        ];
    });
    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
//        Route::post('ativar-usuario', 'AtivacaoController@post');
        Route::get('me', 'AuthController@me');
    });
    Route::resource('ativacao', 'AtivacaoController',
        ['only' => ['update']]);
});

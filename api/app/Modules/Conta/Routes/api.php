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
        'middleware' => 'auth:api',
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
    });

    Route::resource('ativacao', 'AtivacaoController',
        ['only' => ['update']]);


    Route::resource('usuario', 'UsuarioController',[
        'middleware' => 'auth:api',
        'except' => ['create', 'edit']
    ]);

});

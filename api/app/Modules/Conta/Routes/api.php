<?php

Route::group([
    'prefix' => 'conta'
], function () {

    Route::post('primeiro-acesso', 'AtivacaoController@store');
    Route::put('ativar-usuario/{codigo_ativacao}', 'AtivacaoController@update');
    Route::post('recuperar-senha', 'RecuperacaoSenhaController@store');
    Route::put('alterar-senha-recuperada/{codigo_alteracao}', 'RecuperacaoSenhaController@update');
    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function () {
        Route::post('login', 'AuthController@login');
        Route::get('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');


    });
    Route::group([
        'middleware' => 'api',
        'prefix' => 'administrador'
    ], function () {
        Route::patch('usuario/{co_usuario}', 'UsuarioController@update');
        Route::post('usuario', 'UsuarioController@store');
        Route::get('usuario', 'UsuarioController@listarUsuarios');
    });

    //@TODO Alterar pra só o adm ver isso
    Route::apiResource('perfil', 'PerfilApiResourceController');

    Route::put('usuario/alteracao/senha/{co_usuario}', 'UsuarioController@alterarSenha');
});

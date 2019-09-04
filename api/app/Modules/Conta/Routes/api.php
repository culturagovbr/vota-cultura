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

    //@TODO Alterar pra só o adm ver isso
    Route::apiResource('perfil', 'PerfilApiResourceController');

    Route::get('administrador/usuario', 'UsuarioController@listarUsuarios');
    Route::put('usuario/alteracao/senha/{co_usuario}', 'UsuarioController@alterarSenha');
});

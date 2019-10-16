<?php

Route::group([
    'prefix' => 'conselho'
], function () {
    Route::get('{co_conselho}', 'ConselhoApiResourceController@show')->where('co_conselho', '[0-9]+');
    Route::apiResource('/', 'ConselhoApiResourceController');
    Route::apiResource('/indicacao', 'ConselhoIndicacaoApiResourceController');
    Route::post('/indicacao/arquivo', 'ConselhoIndicacaoArquivoController@store');
    Route::patch('{co_conselho}', 'ConselhoApiResourceController@update')->where('co_conselho', '[0-9]+');
    Route::group([
        'prefix' => 'habilitacao'
    ], function () {
        Route::apiResource('/', 'ConselhoHabilitacaoApiResourceController');
        Route::get('/lista-parcial', 'ConselhoHabilitacaoApiResourceController@listaParcial');
    });
    Route::get('lista_habilitacao', 'ConselhoListaHabilitacaoController@index');
    Route::post('habilitacao-recurso', 'ConselhoHabilitacaoRecursoController@store');
});

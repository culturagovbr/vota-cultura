<?php

Route::group([
    'prefix' => 'conselho'
], function () {
    Route::get('{co_conselho}', 'ConselhoApiResourceController@show')->where('co_conselho', '[0-9]+');
    Route::apiResource('/', 'ConselhoApiResourceController');
    Route::patch('{co_conselho}', 'ConselhoApiResourceController@update')->where('co_conselho', '[0-9]+');

    Route::group([
        'prefix' => 'indicacao'
    ], function () {
        Route::apiResource('/', 'ConselhoIndicacaoApiResourceController');
        Route::post('/arquivo', 'ConselhoIndicacaoArquivoController@store');
        Route::apiResource('/habilitacao', 'ConselhoIndicacaoHabilitacaoApiResourceController');
        Route::apiResource('/recurso', 'ConselhoHabilitacaoIndicacaoRecursoApiResourceController');
        Route::get('/lista-parcial', 'ConselhoIndicacaoHabilitacaoApiResourceController@listaParcial');
        Route::get('/regiao/{regiao}', 'ConselhoIndicacaoApiResourceController@indicadosPorRegiao')
            ->where('regiao', '[a-z-]+');
    });


    Route::group([
        'prefix' => 'votacao'
    ], function () {
        Route::apiResource('/', 'ConselhoVotacaoApiResourceController');
        Route::get('/desempate/lista-final', 'ConselhoVotacaoDesempateApiResourceController@listaFinal');
        Route::apiResource('/desempate', 'ConselhoVotacaoDesempateApiResourceController');
    });

    Route::group([
        'prefix' => 'habilitacao'
    ], function () {
        Route::apiResource('/', 'ConselhoHabilitacaoApiResourceController');
        Route::get('/lista-parcial', 'ConselhoHabilitacaoApiResourceController@listaParcial');
    });
    Route::get('lista_habilitacao', 'ConselhoListaHabilitacaoController@index');
    Route::post('habilitacao-recurso', 'ConselhoHabilitacaoRecursoController@store');
});

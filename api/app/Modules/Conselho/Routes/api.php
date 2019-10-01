<?php

Route::group([
    'prefix' => 'conselho'
], function () {
    Route::get('{co_conselho}', 'ConselhoApiResourceController@show')->where('co_conselho', '[0-9]+');
    Route::apiResource('/', 'ConselhoApiResourceController');
    Route::apiResource('habilitacao', 'ConselhoHabilitacaoApiResourceController');
    Route::get('lista_habilitacao', 'ConselhoListaHabilitacaoController@index');
    Route::post('habilitacao-recurso', 'ConselhoHabilitacaoRecursoController@store');
});

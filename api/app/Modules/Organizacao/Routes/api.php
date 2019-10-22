<?php

Route::group([
    'prefix' => 'organizacao'
], function () {
    Route::get('{co_organizacao}', 'OrganizacaoApiResourceController@show')->where('co_organizacao', '[0-9]+');
    Route::get('{co_organizacao}/documentacao-comprobatoria', 'DocumentacaoComprobatoriaController@show')->where('co_organizacao', '[0-9]+');
    Route::post('documentacao-comprobatoria', 'DocumentacaoComprobatoriaController@store');
    Route::apiResource('/', 'OrganizacaoApiResourceController');
    Route::apiResource('criterio', 'CriterioApiResourceController')->only('index', 'show');
    Route::apiResource('segmento', 'SegmentoApiResourceController')->only('index', 'show');
    Route::apiResource('habilitacao', 'OrganizacaoHabilitacaoApiResourceController');
    Route::post('habilitacao-recurso', 'OrganizacaoHabilitacaoRecursoController@store');
    Route::patch('habilitacao-recurso/{coOrganizacaoHabilitacaoRecurso}', 'OrganizacaoHabilitacaoRecursoController@update');
});

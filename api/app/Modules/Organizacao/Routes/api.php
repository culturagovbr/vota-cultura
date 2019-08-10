<?php

Route::group([
    'prefix' => 'organizacao'
], function ($router) {
    Route::apiResource('/', 'OrganizacaoApiResourceController');
    Route::get('{co_organizacao}', 'OrganizacaoApiResourceController@show');
    Route::apiResource('criterio', 'CriterioApiResourceController');
    Route::apiResource('segmento', 'SegmentoApiResourceController');
});

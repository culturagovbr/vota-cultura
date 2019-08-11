<?php

Route::group([
    'prefix' => 'organizacao'
], function ($router) {
    Route::get('{co_organizacao}', 'OrganizacaoApiResourceController@show')->where('co_organizacao', '[0-9]+');;
    Route::apiResource('/', 'OrganizacaoApiResourceController');
    Route::apiResource('criterio', 'CriterioApiResourceController');
    Route::apiResource('segmento', 'SegmentoApiResourceController');
});

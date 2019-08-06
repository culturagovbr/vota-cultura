<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'organizacao'
], function ($router) {
    Route::apiResource('/', 'OrganizacaoApiResourceController');
    Route::apiResource('criterio', 'CriterioApiResourceController');
    Route::apiResource('segmento', 'SegmentoApiResourceController');
});

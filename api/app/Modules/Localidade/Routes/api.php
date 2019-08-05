<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'localidade'
], function ($router) {
    Route::apiResource('uf', 'UFApiResourceController');
    Route::apiResource('municipio', 'MunicipioApiResourceController');
    Route::get('municipio-por-uf/{co_ibge}', 'MunicipioController@show');
});

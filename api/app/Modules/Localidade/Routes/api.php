<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'localidade'
], function ($router) {
    Route::apiResource('uf', 'UfController');
    Route::apiResource('municipio', 'MunicipioController');
});

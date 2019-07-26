<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'organizacao'
], function ($router) {
    Route::apiResource('/', 'OrganizacaoController');
});

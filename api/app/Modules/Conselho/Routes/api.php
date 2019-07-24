<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'conselho'
], function ($router) {

    Route::apiResource('/', 'ConselhoController');
});

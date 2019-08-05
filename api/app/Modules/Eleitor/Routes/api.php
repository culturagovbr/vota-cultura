<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'eleitor'
], function () {
    Route::apiResource('/', 'EleitorController');
});

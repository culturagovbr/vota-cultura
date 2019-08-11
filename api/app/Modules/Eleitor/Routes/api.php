<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'eleitor'
], function () {
    Route::get('{co_eleitor}', 'EleitorApiResourceController@show')->where('co_eleitor', '[0-9]+');;
    Route::apiResource('/', 'EleitorApiResourceController');
});

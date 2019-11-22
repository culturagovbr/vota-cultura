<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'fase'
], function () {
    Route::get('/', 'FaseController@index');
    Route::patch('/{co_fase}', 'FaseController@update');
});

<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'fase'
], function () {
    Route::get('/', 'FaseController@index');
});

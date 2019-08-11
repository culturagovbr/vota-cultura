<?php

use Illuminate\Http\Request;

Route::group([
    'prefix' => 'cronograma'
], function () {
    Route::get('/', 'CronogramaController@index');
});

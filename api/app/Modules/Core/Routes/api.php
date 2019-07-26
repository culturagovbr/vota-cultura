<?php

use Illuminate\Http\Request;


Route::get('/core', function (Request $request) {
    // return $request->core();
})->middleware('api');

<?php

use Illuminate\Http\Request;

Route::get('/upload', function (Request $request) {
    // return $request->upload();
})->middleware('auth:api');

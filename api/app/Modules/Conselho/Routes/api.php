<?php

Route::group([
    'prefix' => 'conselho'
], function () {
    Route::apiResource('/', 'ConselhoApiResourceController');
});

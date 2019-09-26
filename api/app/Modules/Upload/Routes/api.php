<?php

Route::group([
    'prefix' => 'upload'
], function () {
    Route::get('{co_arquivo}', 'UploadController@show')->where('co_arquivo', '[0-9]+');
});

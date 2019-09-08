<?php

Route::group(['prefix' => 'recurso'], function () {
    Route::apiResource('inscricao', 'RecursoInscricaoApiResourceController');
});

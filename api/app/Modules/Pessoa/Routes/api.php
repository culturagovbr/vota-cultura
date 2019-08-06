<?php

use Illuminate\Http\Request;


Route::group([
    'prefix' => 'pessoa'
], function ($router) {
    Route::get('/juridica/{identificador}', 'ReceitaController@consultarDadosPessoaJuridica');
    Route::get('/fisica/{identificador}', 'ReceitaController@consultarDadosPessoaFisica');
});

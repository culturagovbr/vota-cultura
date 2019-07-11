<?php

use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     description="Swagger para API da aplicação. ",
 *     version="1.0.0",
 *     title="Swagger API",
 *     termsOfService="http://xxxxx.xx/termos/",
 *     @OA\Contact(
 *         email="xxxxxx@xxxxx.xx"
 *     ),
 * )
 */
Route::group([
    'prefix' => 'conta'
], function ($router) {
    Route::get('/', function (Request $request) {
        return [
            'rota padrao'
        ];
    });

    /**
     * @OA\Tag(
     *     name="Autenticacao",
     *     description="Endpoint de Autenticacao da aplicação",
     * )
     */

    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
    });
});

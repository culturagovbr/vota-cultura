<?php

namespace App\Modules\Conta\Providers;

use App\Modules\Conta\Http\Middleware\MiddlewareSouAdministrador;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Modules\Conta\Http\Controllers';

    protected $middleware = [
        'MiddlewareSouAdministrador' => MiddlewareSouAdministrador::class
    ];

    public function map()
    {
        $this->mapApiRoutes();
    }

    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace'  => $this->namespace,
            'prefix'     => 'api',
        ], function ($router) {
            require module_path('conta', 'Routes/api.php', 'app');
        });
    }
}

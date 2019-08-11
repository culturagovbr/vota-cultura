<?php

namespace App\Modules\Core\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}

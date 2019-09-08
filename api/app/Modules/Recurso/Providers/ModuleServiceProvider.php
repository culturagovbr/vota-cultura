<?php

namespace App\Modules\Recurso\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('recurso', 'Resources/Lang', 'app'), 'recurso');
        $this->loadViewsFrom(module_path('recurso', 'Resources/Views', 'app'), 'recurso');
        $this->loadMigrationsFrom(module_path('recurso', 'Database/Migrations', 'app'), 'recurso');
        $this->loadConfigsFrom(module_path('recurso', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('recurso', 'Database/Factories', 'app'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}

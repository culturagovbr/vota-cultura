<?php

namespace App\Modules\Conselho\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('conselho', 'Resources/Lang', 'app'), 'conselho');
        $this->loadViewsFrom(module_path('conselho', 'Resources/Views', 'app'), 'conselho');
        $this->loadMigrationsFrom(module_path('conselho', 'Database/Migrations', 'app'), 'conselho');
        $this->loadConfigsFrom(module_path('conselho', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('conselho', 'Database/Factories', 'app'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}

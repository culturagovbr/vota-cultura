<?php

namespace App\Modules\Organizacao\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('organizacao', 'Resources/Lang', 'app'), 'organizacao');
        $this->loadViewsFrom(module_path('organizacao', 'Resources/Views', 'app'), 'organizacao');
        $this->loadMigrationsFrom(module_path('organizacao', 'Database/Migrations', 'app'), 'organizacao');
        $this->loadConfigsFrom(module_path('organizacao', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('organizacao', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}

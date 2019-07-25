<?php

namespace App\Modules\Localizacao\Providers;

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
        $this->loadTranslationsFrom(module_path('localizacao', 'Resources/Lang', 'app'), 'localizacao');
        $this->loadViewsFrom(module_path('localizacao', 'Resources/Views', 'app'), 'localizacao');
        $this->loadMigrationsFrom(module_path('localizacao', 'Database/Migrations', 'app'), 'localizacao');
        $this->loadConfigsFrom(module_path('localizacao', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('localizacao', 'Database/Factories', 'app'));
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

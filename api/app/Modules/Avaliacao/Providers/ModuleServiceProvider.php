<?php

namespace App\Modules\Avaliacao\Providers;

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
        $this->loadTranslationsFrom(module_path('avaliacao', 'Resources/Lang', 'app'), 'avaliacao');
        $this->loadViewsFrom(module_path('avaliacao', 'Resources/Views', 'app'), 'avaliacao');
        $this->loadMigrationsFrom(module_path('avaliacao', 'Database/Migrations', 'app'), 'avaliacao');
        $this->loadConfigsFrom(module_path('avaliacao', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('avaliacao', 'Database/Factories', 'app'));
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

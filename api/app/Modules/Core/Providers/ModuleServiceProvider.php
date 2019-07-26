<?php

namespace App\Modules\Core\Providers;

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
        $this->loadTranslationsFrom(module_path('core', 'Resources/Lang', 'app'), 'core');
        $this->loadViewsFrom(module_path('core', 'Resources/Views', 'app'), 'core');
        $this->loadMigrationsFrom(module_path('core', 'Database/Migrations', 'app'), 'core');
        $this->loadConfigsFrom(module_path('core', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('core', 'Database/Factories', 'app'));
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

<?php

namespace App\Modules\Localidade\Providers;

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
        $this->loadTranslationsFrom(module_path('localidade', 'Resources/Lang', 'app'), 'localidade');
        $this->loadViewsFrom(module_path('localidade', 'Resources/Views', 'app'), 'localidade');
        $this->loadMigrationsFrom(module_path('localidade', 'Database/Migrations', 'app'), 'localidade');
        $this->loadConfigsFrom(module_path('localidade', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('localidade', 'Database/Factories', 'app'));
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

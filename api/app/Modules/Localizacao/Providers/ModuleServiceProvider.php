<?php

namespace App\Modules\Endereco\Providers;

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
        $this->loadTranslationsFrom(module_path('endereco', 'Resources/Lang', 'app'), 'endereco');
        $this->loadViewsFrom(module_path('endereco', 'Resources/Views', 'app'), 'endereco');
        $this->loadMigrationsFrom(module_path('endereco', 'Database/Migrations', 'app'), 'endereco');
        $this->loadConfigsFrom(module_path('endereco', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('endereco', 'Database/Factories', 'app'));
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

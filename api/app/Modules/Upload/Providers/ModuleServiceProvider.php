<?php

namespace App\Modules\Upload\Providers;

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
        $this->loadTranslationsFrom(module_path('upload', 'Resources/Lang', 'app'), 'upload');
        $this->loadViewsFrom(module_path('upload', 'Resources/Views', 'app'), 'upload');
        $this->loadMigrationsFrom(module_path('upload', 'Database/Migrations', 'app'), 'upload');
        $this->loadConfigsFrom(module_path('upload', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('upload', 'Database/Factories', 'app'));
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

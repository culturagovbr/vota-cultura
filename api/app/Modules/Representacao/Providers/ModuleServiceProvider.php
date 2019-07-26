<?php

namespace App\Modules\Representacao\Providers;

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
        $this->loadTranslationsFrom(module_path('representacao', 'Resources/Lang', 'app'), 'representacao');
        $this->loadViewsFrom(module_path('representacao', 'Resources/Views', 'app'), 'representacao');
        $this->loadMigrationsFrom(module_path('representacao', 'Database/Migrations', 'app'), 'representacao');
        $this->loadConfigsFrom(module_path('representacao', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('representacao', 'Database/Factories', 'app'));
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

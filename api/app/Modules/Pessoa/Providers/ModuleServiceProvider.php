<?php

namespace App\Modules\Pessoa\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('pessoa', 'Resources/Lang', 'app'), 'pessoa');
        $this->loadViewsFrom(module_path('pessoa', 'Resources/Views', 'app'), 'pessoa');
        $this->loadMigrationsFrom(module_path('pessoa', 'Database/Migrations', 'app'), 'pessoa');
        $this->loadConfigsFrom(module_path('pessoa', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('pessoa', 'Database/Factories', 'app'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}

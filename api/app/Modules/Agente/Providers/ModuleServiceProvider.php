<?php

namespace App\Modules\Agente\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('agente', 'Resources/Lang', 'app'), 'agente');
        $this->loadViewsFrom(module_path('agente', 'Resources/Views', 'app'), 'agente');
        $this->loadMigrationsFrom(module_path('agente', 'Database/Migrations', 'app'), 'agente');
        $this->loadConfigsFrom(module_path('agente', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('agente', 'Database/Factories', 'app'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}

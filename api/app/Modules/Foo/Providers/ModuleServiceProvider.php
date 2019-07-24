<?php

namespace App\Modules\Foo\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('foo', 'Resources/Lang', 'app'), 'foo');
        $this->loadViewsFrom(module_path('foo', 'Resources/Views', 'app'), 'foo');
        $this->loadMigrationsFrom(module_path('foo', 'Database/Migrations', 'app'), 'foo');
        $this->loadConfigsFrom(module_path('foo', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('foo', 'Database/Factories', 'app'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}

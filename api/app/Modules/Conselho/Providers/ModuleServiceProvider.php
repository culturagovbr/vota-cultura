<?php

namespace App\Modules\Conselho\Providers;

use Caffeinated\Modules\Support\ServiceProvider;
use App\Modules\Organizacao\Services\Conselho as ConselhoService;
use App\Modules\Representacao\Model\Conselho as ConselhoModel;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('conselho', 'Resources/Lang', 'app'), 'conselho');
        $this->loadViewsFrom(module_path('conselho', 'Resources/Views', 'app'), 'conselho');
        $this->loadMigrationsFrom(module_path('conselho', 'Database/Migrations', 'app'), 'conselho');
        $this->loadConfigsFrom(module_path('conselho', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('conselho', 'Database/Factories', 'app'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(ConselhoService::class, function ($app) {
            return new ConselhoService(
                $app->make(ConselhoModel::class)
            );
        });
    }
}

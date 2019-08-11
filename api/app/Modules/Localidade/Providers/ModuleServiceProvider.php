<?php

namespace App\Modules\Localidade\Providers;

use Caffeinated\Modules\Support\ServiceProvider;
use App\Modules\Localidade\Service\Municipio as MunicipioService;
use App\Modules\Localidade\Model\Municipio as MunicipioModel;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('localidade', 'Resources/Lang', 'app'), 'localidade');
        $this->loadViewsFrom(module_path('localidade', 'Resources/Views', 'app'), 'localidade');
        $this->loadMigrationsFrom(module_path('localidade', 'Database/Migrations', 'app'), 'localidade');
        $this->loadConfigsFrom(module_path('localidade', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('localidade', 'Database/Factories', 'app'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(MunicipioService::class, function ($app) {
            return new MunicipioService(
                $app->make(MunicipioModel::class)
            );
        });
    }
}

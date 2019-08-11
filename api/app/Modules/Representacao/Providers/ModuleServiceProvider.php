<?php

namespace App\Modules\Representacao\Providers;

use Caffeinated\Modules\Support\ServiceProvider;
use App\Modules\Representacao\Service\Representante as RepresentanteService;
use App\Modules\Representacao\Model\Representante as RepresentanteModel;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('representacao', 'Resources/Lang', 'app'), 'representacao');
        $this->loadViewsFrom(module_path('representacao', 'Resources/Views', 'app'), 'representacao');
        $this->loadMigrationsFrom(module_path('representacao', 'Database/Migrations', 'app'), 'representacao');
        $this->loadConfigsFrom(module_path('representacao', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('representacao', 'Database/Factories', 'app'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(RepresentanteService::class, function($app) {
            return new RepresentanteService(
                $app->make(RepresentanteModel::class)
            );
        });
    }
}

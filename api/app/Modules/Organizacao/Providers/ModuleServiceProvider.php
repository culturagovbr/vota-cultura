<?php

namespace App\Modules\Organizacao\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

use App\Modules\Organizacao\Services\Criterio as CriterioService;
use App\Modules\Organizacao\Services\Organizacao as OrganizacaoService;
use App\Modules\Organizacao\Services\Segmento as SegmentoService;

use App\Modules\Representacao\Model\Criterio as CriterioModel;
use App\Modules\Representacao\Model\Organizacao as OrganizacaoModel;
use App\Modules\Representacao\Model\Segmento as SegmentoModel;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('organizacao', 'Resources/Lang', 'app'), 'organizacao');
        $this->loadViewsFrom(module_path('organizacao', 'Resources/Views', 'app'), 'organizacao');
        $this->loadMigrationsFrom(module_path('organizacao', 'Database/Migrations', 'app'), 'organizacao');
        $this->loadConfigsFrom(module_path('organizacao', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('organizacao', 'Database/Factories', 'app'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(CriterioService::class, function ($app) {
            return new CriterioService(
                $app->make(CriterioModel::class)
            );
        });
        $this->app->bind(OrganizacaoService::class, function ($app) {
            return new OrganizacaoService(
                $app->make(OrganizacaoModel::class)
            );
        });
        $this->app->bind(SegmentoService::class, function ($app) {
            return new SegmentoService(
                $app->make(SegmentoModel::class)
            );
        });
    }
}

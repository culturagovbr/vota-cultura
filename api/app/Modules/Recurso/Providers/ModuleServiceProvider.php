<?php

namespace App\Modules\Recurso\Providers;

use App\Modules\Recurso\Mail\RecursoInscricao\CadastroComSucesso;
use App\Modules\Recurso\Model\Criterio as CriterioModel;
use App\Modules\Recurso\Model\RecursoInscricao as RecursoInscricaoModel;
use App\Modules\Recurso\Model\Segmento as SegmentoModel;
use App\Modules\Recurso\Service\Criterio as CriterioService;
use App\Modules\Recurso\Service\RecursoInscricao as RecursoInscricaoService;
use App\Modules\Recurso\Service\Segmento as SegmentoService;
use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('recurso', 'Resources/Lang', 'app'), 'recurso');
        $this->loadViewsFrom(module_path('recurso', 'Resources/Views', 'app'), 'recurso');
        $this->loadMigrationsFrom(module_path('recurso', 'Database/Migrations', 'app'), 'recurso');
        $this->loadConfigsFrom(module_path('recurso', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('recurso', 'Database/Factories', 'app'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(RecursoInscricaoService::class, function ($app) {
            return new RecursoInscricaoService(
                $app->make(RecursoInscricaoModel::class)
            );
        });
        $this->app->bind(CadastroComSucesso::class, function ($app, $parametros) {
            if($parametros instanceof RecursoInscricaoModel) {
                return new CadastroComSucesso($parametros);
            }
            return new CadastroComSucesso($app->make(RecursoInscricaoModel::class, $parametros));
        });
        $this->app->bind(RecursoInscricaoModel::class, function ($app, $parametros) {
            if($parametros instanceof RecursoInscricaoModel) {
                return $parametros;
            }
            return new RecursoInscricaoModel($parametros);
        });
    }
}

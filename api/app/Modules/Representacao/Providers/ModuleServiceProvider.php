<?php

namespace App\Modules\Representacao\Providers;

use App\Modules\Representacao\Http\Resources\RepresentanteArquivoAvaliacao;
use App\Modules\Representacao\Model\Representante as RepresentanteModel;
use App\Modules\Representacao\Model\RepresentanteArquivoAvaliacao as RepresentanteArquivoAvaliacaoModel;
use App\Modules\Representacao\Service\Representante as RepresentanteService;
use Caffeinated\Modules\Support\ServiceProvider;

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
        $this->app->bind(RepresentanteService::class, function($app, $parametros) {
            if($parametros instanceof RepresentanteModel) {
                return new RepresentanteService($parametros);
            }
            return new RepresentanteService($app->make(RepresentanteModel::class, $parametros));
        });
        $this->app->bind(RepresentanteModel::class, function ($app, $parametros) {
            if($parametros instanceof RepresentanteModel) {
                return $parametros;
            }
            return new RepresentanteModel($parametros);
        });
        $this->app->bind(RepresentanteArquivoAvaliacaoModel::class, function ($app, $parametros) {
            return new RepresentanteArquivoAvaliacaoModel($parametros);
        });
        $this->app->bind(RepresentanteArquivoAvaliacao::class, function ($app, $parametros) {
            return new RepresentanteArquivoAvaliacao($app->make(
                RepresentanteArquivoAvaliacaoModel::class,
                $parametros
            ));
        });
    }
}

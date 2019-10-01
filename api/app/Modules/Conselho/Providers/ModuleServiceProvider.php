<?php

namespace App\Modules\Conselho\Providers;

use App\Modules\Conselho\Mail\Conselho\CadastroComSucesso;
use App\Modules\Conselho\Mail\Conselho\CadastroHabilitacaoRecursoSucesso;
use Caffeinated\Modules\Support\ServiceProvider;
use App\Modules\Conselho\Service\Conselho as ConselhoService;
use App\Modules\Conselho\Model\Conselho as ConselhoModel;

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
        $this->app->bind(CadastroComSucesso::class, function ($app, $parametros) {
            if($parametros instanceof ConselhoModel) {
                return new CadastroComSucesso($parametros);
            }
            return new CadastroComSucesso($app->make(ConselhoModel::class, $parametros));
        });

        $this->app->bind(CadastroHabilitacaoRecursoSucesso::class, function ($app, $parametros) {
            return new CadastroHabilitacaoRecursoSucesso( $parametros);
        });
        $this->app->bind(ConselhoModel::class, function ($app, $parametros) {
            if($parametros instanceof ConselhoModel) {
                return $parametros;
            }
            return new ConselhoModel($parametros);
        });
    }
}

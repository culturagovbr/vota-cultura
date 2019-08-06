<?php

namespace App\Modules\Pessoa\Providers;

use App\Modules\Pessoa\Service\Receita as ReceitaService;
use Caffeinated\Modules\Support\ServiceProvider;
use App\Modules\Pessoa\Model\Receita as ReceitaModel;

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
        $this->app->bind(ReceitaService::class, function ($app) {
            /**
             * @var ReceitaModel $modelo
             */
            $modelo = $app->makeWith(ReceitaModel::class, [
                'receitaHost' => getenv('RECEITA_HOST'),
                'receitaUsuario' => getenv('RECEITA_USER'),
                'receitaSenha' => getenv('RECEITA_PASSWORD'),
            ]);

            if (!$modelo->obterReceitaHost()) {
                throw new \HttpException("Variável de ambiente `RECEITA_HOST` não definida.");
            }
            if (!$modelo->obterReceitaUsuario()) {
                throw new \HttpException("Variável de ambiente `RECEITA_USER` não definida.");
            }
            if (!$modelo->obterReceitaSenha()) {
                throw new \HttpException("Variável de ambiente `RECEITA_PASSWORD` não definida.");
            }

            return new ReceitaService($modelo);
        });
    }
}

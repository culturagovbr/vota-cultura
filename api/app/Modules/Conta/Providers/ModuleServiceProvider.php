<?php

namespace App\Modules\Conta\Providers;

use App\Modules\Conta\Mail\Usuario\CadastroComSucesso;
use App\Modules\Conta\Model\Usuario;
use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('conta', 'Resources/Lang', 'app'), 'conta');
        $this->loadViewsFrom(module_path('conta', 'Resources/Views', 'app'), 'conta');
        $this->loadMigrationsFrom(module_path('conta', 'Database/Migrations', 'app'), 'conta');
        $this->loadConfigsFrom(module_path('conta', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('conta', 'Database/Factories', 'app'));
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AutenticacaoServiceProvider::class);
        $this->app->bind(CadastroComSucesso::class, function ($app, $parametros) {
            return new CadastroComSucesso($app->make(Usuario::class, $parametros));
        });
        $this->app->bind(Usuario::class, function ($app, $parametros) {
            return new Usuario($parametros);
        });
    }
}

<?php

namespace App\Modules\Conta\Providers;

use App\Modules\Conta\Http\Resources\Perfil as PerfilResource;
use App\Modules\Conta\Http\Resources\Usuario as UsuarioResource;
use App\Modules\Conta\Mail\Usuario\CadastroComSucesso;
use App\Modules\Conta\Model\Perfil as PerfilModel;
use App\Modules\Conta\Model\Usuario as UsuarioModel;
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
            return new CadastroComSucesso($app->make(UsuarioModel::class, $parametros));
        });

        $this->app->bind(UsuarioModel::class, function ($app, $parametros) {
            return new UsuarioModel($parametros);
        });

        $this->app->bind(UsuarioResource::class, function ($app, $parametros) {
            return new UsuarioResource(app(UsuarioModel::class, $parametros));
        });

        $this->app->bind(PerfilModel::class, function ($app, $parametros) {
            return new PerfilModel($parametros);
        });

        $this->app->bind(PerfilResource::class, function ($app, $parametros) {
            if($parametros instanceof PerfilModel) {
                return new PerfilResource($parametros);
            }
            return new PerfilResource(app(PerfilModel::class, $parametros));
        });
    }
}

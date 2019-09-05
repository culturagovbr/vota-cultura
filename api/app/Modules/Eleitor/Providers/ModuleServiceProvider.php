<?php

namespace App\Modules\Eleitor\Providers;

use App\Modules\Eleitor\Mail\Eleitor\CadastroComSucesso;
use App\Modules\Eleitor\Model\Eleitor;
use Caffeinated\Modules\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('eleitor', 'Resources/Lang', 'app'), 'eleitor');
        $this->loadViewsFrom(module_path('eleitor', 'Resources/Views', 'app'), 'eleitor');
        $this->loadMigrationsFrom(module_path('eleitor', 'Database/Migrations', 'app'), 'eleitor');
        $this->loadConfigsFrom(module_path('eleitor', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('eleitor', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind(CadastroComSucesso::class, function ($app, $parametros) {
            if($parametros instanceof Eleitor) {
                return new CadastroComSucesso($parametros);
            }
            return new CadastroComSucesso($app->make(Eleitor::class, $parametros));
        });
        $this->app->bind(Eleitor::class, function ($app, $parametros) {
            if($parametros instanceof Eleitor) {
                return $parametros;
            }
            return new Eleitor($parametros);
        });
    }
}

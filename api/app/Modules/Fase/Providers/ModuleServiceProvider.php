<?php

namespace App\Modules\Fase\Providers;

use App\Modules\Fase\Model\Fase as FaseModel;
use App\Modules\Recurso\Http\Resources\Fase as FaseResource;
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
        $this->loadTranslationsFrom(module_path('fase', 'Resources/Lang', 'app'), 'fase');
        $this->loadViewsFrom(module_path('fase', 'Resources/Views', 'app'), 'fase');
        $this->loadMigrationsFrom(module_path('fase', 'Database/Migrations', 'app'), 'fase');
        $this->loadConfigsFrom(module_path('fase', 'Config', 'app'));
        $this->loadFactoriesFrom(module_path('fase', 'Database/Factories', 'app'));
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->bind(FaseResource::class, function ($app, $parametros) {
            if($parametros instanceof FaseModel) {
                return new FaseResource($parametros);
            }
            return new FaseResource($app->make(FaseModel::class, $parametros));
        });
    }
}

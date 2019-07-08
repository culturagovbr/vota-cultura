<?php

namespace App\Modules\Conta\Providers;

use Caffeinated\Modules\Support\ServiceProvider;

class AutenticacaoServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        \Auth::provider('autenticacao', function () {
            return new AutenticacaoUserProvider();
        });
    }
}

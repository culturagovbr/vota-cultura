<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Organizacao\Services\Organizacao as OrganizacaoService;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;

class OrganizacaoController extends AApiResourceController
{
    use TApiResourceUpdate,
        TApiResourceDestroy;

    public function __construct(OrganizacaoService $service)
    {
        parent::__construct($service);
    }
}

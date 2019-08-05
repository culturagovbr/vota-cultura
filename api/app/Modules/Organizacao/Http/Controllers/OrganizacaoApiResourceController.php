<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Core\Http\Controllers\Traits\TApiResourceIndex;
use App\Modules\Organizacao\Service\Organizacao as OrganizacaoService;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;

class OrganizacaoApiResourceController extends AApiResourceController
{
    use TApiResourceUpdate,
        TApiResourceDestroy,
        TApiResourceIndex;

    public function __construct(OrganizacaoService $service)
    {
        parent::__construct($service);
    }


}

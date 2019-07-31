<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Service\Conselho as ConselhoService;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;

class ConselhoController extends AApiResourceController
{
    use TApiResourceUpdate,
        TApiResourceDestroy;

    public function __construct(ConselhoService $service)
    {
        $this->service = $service;
    }
}

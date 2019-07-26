<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Services\Conselho as ConselhoService;
use App\Modules\Core\Http\Controllers\AApiResourceController;

class ConselhoController extends AApiResourceController
{
    public function __construct(ConselhoService $service)
    {
        $this->service = $service;
    }
}

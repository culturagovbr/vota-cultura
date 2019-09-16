<?php

namespace App\Modules\Localidade\Http\Controllers;

use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Localidade\Model\UF;
use App\Modules\Localidade\Service\UF as UFService;

class UFApiResourceController extends AApiResourceController
{
    public function __construct(UFService $service)
    {
        parent::__construct($service);
    }

    public function show(UF $model): \Illuminate\Http\JsonResponse
    {
        return parent::genericShow($model);
    }
}

<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Organizacao\Model\Criterio;
use App\Modules\Organizacao\Service\Criterio as CriterioService;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class CriterioApiResourceController extends AApiResourceController
{
    public function __construct(CriterioService $service)
    {
        parent::__construct($service);
    }

    public function show(Criterio $model): \Illuminate\Http\JsonResponse
    {
        return parent::genericShow($model);
    }
}

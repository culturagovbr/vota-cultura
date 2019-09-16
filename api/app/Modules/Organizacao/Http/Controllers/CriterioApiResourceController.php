<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Organizacao\Model\Criterio as CriterioModel;
use App\Modules\Organizacao\Service\Criterio as CriterioService;
use Illuminate\Http\JsonResponse;

class CriterioApiResourceController extends AApiResourceController
{
    public function __construct(CriterioService $service)
    {
        parent::__construct($service);
    }

    public function show(CriterioModel $criterio): JsonResponse
    {
        return parent::genericShow($criterio);
    }
}

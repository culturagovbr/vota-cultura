<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Organizacao\Model\Segmento;
use App\Modules\Organizacao\Service\Segmento as SegmentoService;
use Illuminate\Http\JsonResponse;

class SegmentoApiResourceController extends AApiResourceController
{
    public function __construct(SegmentoService $service)
    {
        parent::__construct($service);
    }

    public function show(Segmento $model): JsonResponse
    {
        return parent::genericShow($model);
    }
}

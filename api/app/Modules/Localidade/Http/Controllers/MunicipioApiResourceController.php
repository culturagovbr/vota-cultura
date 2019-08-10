<?php

namespace App\Modules\Localidade\Http\Controllers;

use App\Modules\Localidade\Model\Municipio;
use App\Modules\Localidade\Service\Municipio as MunicipioService;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Organizacao\Model\Organizacao;

class MunicipioApiResourceController extends AApiResourceController
{
    public function __construct(MunicipioService $service)
    {
        parent::__construct($service);
    }

    public function show(Municipio $model): \Illuminate\Http\JsonResponse
    {
        return parent::genericShow($model);
    }
}

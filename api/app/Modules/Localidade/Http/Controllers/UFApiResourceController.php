<?php

namespace App\Modules\Localidade\Http\Controllers;

use App\Modules\Localidade\Model\Uf;
use App\Modules\Localidade\Service\Uf as UfService;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Organizacao\Model\Organizacao;

class UFApiResourceController extends AApiResourceController
{
    public function __construct(UfService $service)
    {
        parent::__construct($service);
    }

    public function show(Uf $model): \Illuminate\Http\JsonResponse
    {
        return parent::genericShow($model);
    }
}

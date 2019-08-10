<?php

namespace App\Modules\Eleitor\Http\Controllers;

use App\Modules\Eleitor\Model\Eleitor;
use App\Modules\Eleitor\Service\Eleitor as EleitorService;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;
use App\Modules\Organizacao\Model\Organizacao;
use Illuminate\Http\Request;

class EleitorApiResourceController extends AApiResourceController
{
    use TApiResourceUpdate,
        TApiResourceDestroy;

    public function __construct(EleitorService $service)
    {
        return parent::__construct($service);
    }

    public function show(Eleitor $model): \Illuminate\Http\JsonResponse
    {
        return parent::genericShow($model);
    }
}

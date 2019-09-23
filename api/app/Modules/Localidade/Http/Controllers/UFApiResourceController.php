<?php

namespace App\Modules\Localidade\Http\Controllers;

use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Localidade\Model\Uf;
use App\Modules\Localidade\Service\Uf as UfService;
use Illuminate\Http\Response;

class UFApiResourceController extends AApiResourceController
{
    public function __construct(UfService $service)
    {
        parent::__construct($service);
    }

    /** @todo teste */
    public function index(): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            ['DF'],
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }

    public function show(Uf $model): \Illuminate\Http\JsonResponse
    {
        return parent::genericShow($model);
    }
}

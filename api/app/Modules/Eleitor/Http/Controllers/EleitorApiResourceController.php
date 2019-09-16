<?php
declare(strict_types=1);

namespace App\Modules\Eleitor\Http\Controllers;

use App\Modules\Eleitor\Http\Resources\Eleitor as EleitorResource;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;
use App\Modules\Eleitor\Service\Eleitor as EleitorService;
use Illuminate\Http\Response;

class EleitorApiResourceController extends AApiResourceController
{
    use TApiResourceUpdate,
        TApiResourceDestroy;

    public function __construct(EleitorService $service)
    {
        $this->middleware('auth:api')->except('store');
        return parent::__construct($service);
    }

    public function show($identificador): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
           new EleitorResource(
                $this->service->obterUm($identificador)
            ),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

}

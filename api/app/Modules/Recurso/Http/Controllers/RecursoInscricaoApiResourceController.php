<?php

namespace App\Modules\Recurso\Http\Controllers;

use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;
use App\Modules\Recurso\Http\Resources\RecursoInscricao as RecursoInscricaoResource;
use App\Modules\Recurso\Service\RecursoInscricao as RecursoInscricaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RecursoInscricaoApiResourceController extends AApiResourceController
{
    use TApiResourceUpdate,
        TApiResourceDestroy;

    public function __construct(RecursoInscricaoService $service)
    {
        $this->middleware('auth:api')->except(
            ['store']
        );
        parent::__construct($service);
    }

    public function index(): JsonResponse
    {
        return $this->sendResponse(
            RecursoInscricaoResource::collection($this->service->obterTodos()),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }

    public function update(Request $request, $identificador)
    {
        return $this->sendResponse(
            new RecursoInscricaoResource(
                $this->service->atualizar($request, $identificador)
            ),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }
}

<?php

namespace App\Modules\Recurso\Http\Controllers;

use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;
use App\Modules\Recurso\Http\Resources\RecursoInscricao;
use App\Modules\Recurso\Service\RecursoInscricao as RecursoInscricaoService;
use Illuminate\Http\JsonResponse;
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

    public function show($identificador): JsonResponse
    {
        return $this->sendResponse(
            new RecursoInscricaoService($this->service->obterUm($identificador)),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }

    public function index(): JsonResponse
    {
        return $this->sendResponse(
            RecursoInscricao::collection($this->service->obterTodos()),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }
}

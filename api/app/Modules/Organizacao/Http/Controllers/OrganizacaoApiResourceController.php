<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Conselho\Http\Resources\Organizacao;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;
use App\Modules\Organizacao\Http\Resources\Organizacao as OrganizacaoResource;
use App\Modules\Organizacao\Service\Organizacao as OrganizacaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OrganizacaoApiResourceController extends AApiResourceController
{
    use TApiResourceUpdate,
        TApiResourceDestroy;

    public function __construct(OrganizacaoService $service)
    {
        $this->middleware('auth:api')->except(
            ['store', 'index']
        );
        parent::__construct($service);
    }

    public function show($identificador): JsonResponse
    {
        return $this->sendResponse(
            new OrganizacaoResource($this->service->obterUm($identificador)),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }

    public function index(): JsonResponse
    {
        return $this->sendResponse(
            OrganizacaoResource::collection($this->service->obterTodos()),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }
}

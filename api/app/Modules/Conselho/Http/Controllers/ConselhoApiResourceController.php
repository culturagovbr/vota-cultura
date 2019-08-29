<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Http\Resources\Conselho;
use App\Modules\Conselho\Service\Conselho as ConselhoService;
use App\Modules\Core\Exceptions\EParametrosInvalidos;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ConselhoApiResourceController extends AApiResourceController
{
    use TApiResourceUpdate,
        TApiResourceDestroy;

    public function __construct(ConselhoService $service)
    {
        $this->middleware('auth:api')->except('store');
        $this->service = $service;
    }

    public function show($identificador): JsonResponse
    {
        return $this->sendResponse(
            new Conselho($this->service->obterUm($identificador)),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }

    public function index(): JsonResponse
    {
        throw new EParametrosInvalidos("Método não disponível");
    }
}

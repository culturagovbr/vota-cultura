<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Service\ConselhoIndicacaoHabilitacao as ConselhoIndicacaoHabilitacaoService;
use App\Modules\Core\Exceptions\EMetodoIndisponivel;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceDestroy;
use App\Modules\Core\Http\Controllers\Traits\TApiResourceUpdate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConselhoIndicacaoHabilitacaoApiResourceController extends AApiResourceController
{
    use TApiResourceUpdate,
        TApiResourceDestroy;

    public function __construct(ConselhoIndicacaoHabilitacaoService $service)
    {
        $this->middleware('auth:api')->except(['store', 'index', 'update']);
        return parent::__construct($service);
    }

    public function index(): JsonResponse
    {
        return $this->sendResponse(
            $this->service->obterTodos(),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

    public function show(): JsonResponse
    {
        throw new EMetodoIndisponivel("Método indisponível.");
    }

    public function store(Request $request): JsonResponse
    {
        return $this->sendResponse(
            $this->service->cadastrar(collect($request->all())),
            "Operação realizada com sucesso",
            Response::HTTP_CREATED
        );
    }

    public function update(Request $request, $identificador): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $this->service->atualizar($request, $identificador),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }
}

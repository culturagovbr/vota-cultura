<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Http\Resources\Conselho;
use App\Modules\Conselho\Http\Resources\ConselhoHabilitacaoListaFinal;
use App\Modules\Conselho\Service\ConselhoHabilitacao;
use App\Modules\Core\Exceptions\EMetodoIndisponivel;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConselhoHabilitacaoApiResourceController extends AApiResourceController
{

    public function __construct(ConselhoHabilitacao $service)
    {
        $this->middleware('auth:api')->except('listaParcial');
        return parent::__construct($service);
    }

    public function index(): JsonResponse
    {
        $conselhoService = app(\App\Modules\Conselho\Service\Conselho::class, request()->all());
        return $this->sendResponse(
            Conselho::collection($conselhoService->obterTodos()),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

    public function store(Request $request): JsonResponse
    {
        return $this->sendResponse(
            $this->service->cadastrar(collect($request->all())),
            "Operação realizada com sucesso",
            Response::HTTP_CREATED
        );
    }

    public function show($identificador): JsonResponse
    {
        throw new EMetodoIndisponivel("Método indisponível.");
    }

    public function listaParcial(): JsonResponse
    {
        $conselhoService = app(\App\Modules\Conselho\Service\Conselho::class, request()->all());
        return $this->sendResponse(
            ConselhoHabilitacaoListaFinal::collection($conselhoService->obterTodosParcialmenteHabilitados()),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }

}

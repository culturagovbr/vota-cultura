<?php

namespace App\Modules\Conselho\Http\Controllers;

use App\Modules\Conselho\Http\Resources\Conselho;
use App\Modules\Conselho\Service\Conselho as ConselhoService;
use App\Modules\Core\Exceptions\EMetodoIndisponivel;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConselhoHabilitacaoApiResourceController extends AApiResourceController
{

    public function __construct(ConselhoService $service)
    {
        $this->middleware('auth:api');
        return parent::__construct($service);
    }

    public function index(): JsonResponse
    {
        return $this->sendResponse(
            Conselho::collection($this->service->obterTodos()),
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
        throw new EMetodoIndisponivel("E-mail não definido.");
    }

}

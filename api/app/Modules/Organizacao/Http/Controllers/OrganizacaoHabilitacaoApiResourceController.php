<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Modules\Organizacao\Http\Resources\Organizacao;
use App\Modules\Organizacao\Service\OrganizacaoHabilitacao;
use App\Modules\Core\Exceptions\EMetodoIndisponivel;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrganizacaoHabilitacaoApiResourceController extends AApiResourceController
{

    public function __construct(OrganizacaoHabilitacao $service)
    {
        $this->middleware('api');
        return parent::__construct($service);
    }

    public function index(): JsonResponse
    {
        $organizacaoService = app(\App\Modules\Organizacao\Service\Organizacao::class, request()->all());
        return $this->sendResponse(
            Organizacao::collection($organizacaoService->obterTodos()),
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

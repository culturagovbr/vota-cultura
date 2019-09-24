<?php

namespace App\Modules\Organizacao\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Organizacao\Service\Organizacao as OrganizacaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class DocumentacaoComprobatoriaController extends Controller
{
    private $service;

    public function __construct(OrganizacaoService $service)
    {
        $this->service = $service;
        $this->middleware('auth:api');
    }

    public function store(Request $request): JsonResponse
    {
        return $this->sendResponse(
            $this->service->anexarDocumentacaoComprobatoria(
                $request->slug,
                $request->file('binario'),
                (bool) json_decode($request->enviarEmail)
            ),
            "Documentação enviada com sucesso!",
            Response::HTTP_CREATED
        );
    }

    public function show($identificador): JsonResponse
    {
        return $this->sendResponse(
            $this->service->obterDocumentacaoComprobatoria((int)$identificador),
            "Operação realizada com sucesso",
            Response::HTTP_OK
        );
    }
}

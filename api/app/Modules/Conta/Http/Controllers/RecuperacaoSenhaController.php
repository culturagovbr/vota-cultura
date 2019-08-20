<?php

namespace App\Modules\Conta\Http\Controllers;

use App\Modules\Conta\Service\RecuperacaoSenha as RecuperacaoSenhaService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class RecuperacaoSenhaController extends Controller
{

    private $recuperacaoSenhaService;

    public function __construct(RecuperacaoSenhaService $recuperacaoSenhaService)
    {
        $this->recuperacaoSenhaService = $recuperacaoSenhaService;

    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse($this->recuperacaoSenhaService->recuperarSenha($request->all()),
            "Operação Realizada com Sucesso",
            Response::HTTP_CREATED
        );
    }


    public function update(Request $request, $ds_codigo_alteracao): \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $this->recuperacaoSenhaService->alterarSenha($ds_codigo_alteracao, $request->only(['ds_senha'])),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }
}

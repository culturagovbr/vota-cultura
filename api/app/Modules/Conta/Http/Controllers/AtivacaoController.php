<?php

namespace App\Modules\Conta\Http\Controllers;


use App\Modules\Conta\Service\Usuario as UsuarioService;
use App\Modules\Core\Http\Controllers\AApiResourceController;
use Illuminate\Http\Response;

class AtivacaoController extends AApiResourceController
{
    private $usuarioService;

    public function __construct(UsuarioService $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function store(\Illuminate\Http\Request $request) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $this->usuarioService->gerarPrimeiroAcesso($request),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }

    public function update($codigo_ativacao) : \Illuminate\Http\JsonResponse
    {
        return $this->sendResponse(
            $this->usuarioService->ativarUsuarioPorCodigoAtivacao($codigo_ativacao),
            "Operação Realizada com Sucesso",
            Response::HTTP_OK
        );
    }
}
